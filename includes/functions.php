<?php
function markAsActivePage($page)
{
    //check if it is the current page and return the active class name
    $activeClass = '';
    $currentPage = basename($_SERVER['PHP_SELF']);
    if ($currentPage == $page)
    {
        $activeClass = 'active';
    }
    //the account will be marked as active for pages: messages & profile
    if ($page == 'account' && in_array($currentPage, ['message.php', 'profile.php']))
    {
        $activeClass = 'active';
    }
    return $activeClass;
}

function getJsonRow($status, $msg)
{
    $response['status'] = $status;
    $response['msg'] = $msg;
    getJsonList($response);
}

function getJsonList($row)
{
    if(count($row) > 0)
    {
        echo json_encode($row, JSON_PRETTY_PRINT);
    }
    exit;
}


function doValidateApiParams($data)
{
    if(count($data) > 0)
    {
        foreach($data as $key => $val)
        {
        $validate = doCheckParamIssetEmpty($key, $val);
        if(!$validate['status'])
        {
            getJsonRow(false, $validate['msg']);
        }
        }
    }
}

function doCheckParamIssetEmpty($param, $data)
{
    $datax = [
        'status' => true,
        'msg' => ''
    ];
  
    $param = strtolower($param);
    $method = $data['method'];
    $label = $data['label'];
    $length = isset($data['length']) ? $data['length'] : [0,0];
    $required = isset($data['required']) ? $data['required'] : false;
    $type = isset($data['type']) ? $data['type'] : "";
    $isEmail = isset($data['is_email']) ? $data['is_email'] : false;

    if(empty($label))
    {
        $label = $param;
    }
    if(strtolower($method) == 'post')
    {
        $isset = isset($_POST[$param]);
        $value = isset($_POST[$param]) ? $_POST[$param] : "";
    }
    elseif(strtolower($method) == 'get')
    {
        $isset = isset($_GET[$param]);
        $value = $isset ? $_GET[$param] : "";
    }
    else
    {
        $isset = isset($_REQUEST[$param]);
        $value = $isset ? $_REQUEST[$param] : "";
    }
    
    if($required)
    {
        $isset = $isset && !empty($value);
        if(!$isset)
        {
        $datax['status'] = false;
        $datax['msg'] = $label . ' is required.';
        return $datax;
        }
    }
    if(!empty($type) && !empty($value))
    {
        if($type == 'string')
        {
        if(!is_string($value))
        {
            $datax['status'] = false;
            $datax['msg'] = $label . ' must be a string.';
            return $datax;
        }
        }
        elseif($type == 'number')
        {
        if(!is_numeric($value))
        {
            $datax['status'] = false;
            $datax['msg'] = $label . ' must contain only digits.';
            return $datax;
        }
        }
    }
    if((!empty($value) && $isEmail) || (!empty($value) && trim($param) == 'email'))
    {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL))
        {
        $datax['status'] = false;
        $datax['msg'] = $label . ' must contain a valid email.';
        return $datax;
        }
    }
    if($length[0] > 0 && $length[1] > 0 && $length[0] == $length[1] && !empty($value))
    {
        $isset = $isset && strlen($value) == $length[0];
        if(!$isset)
        {
        $datax['status'] = false;
        if(strpos($param, '_id') !== false || $param == 'id')
        {
            $datax['msg'] = $label . ' in invalid.';
        }
        else
        {
            $datax['msg'] = $label . ' must be equal to ' . $length[0] .' characters.';
        }
        return $datax;
        }
    }
    if($length[0] > 0 && !empty($value))
    {
        $isset = $isset && strlen($value) >= $length[0];
        if(!$isset)
        {
            $datax['status'] = false;
            if(strpos($param, '_id') !== false || $param == 'id')
            {
            $datax['msg'] = $label . ' in invalid.';
            }
            else
            {
            $datax['msg'] = $label . ' must be greater than or equal to ' . $length[0] .' characters.';
            }
            return $datax;
        }
    }
    if($length[1] > 0 && !empty($value))
    {
        $isset = $isset && strlen($value) <= $length[1];
        if(!$isset)
        {
            $datax['status'] = false;
            if(strpos($param, '_id') !== false || $param == 'id')
            {
                $datax['msg'] = $label . ' in invalid.';
            }
            else
            {
                $datax['msg'] = $label . ' must be less than or equal to ' . $length[1] .' characters.';
            }
            return $datax;
        }
    }
    return $datax;
}

function stringToUpper($text)
{
    return strtoupper(strtolower($text));
}

function getUserSession()
{
    return $_SESSION['user'];
}