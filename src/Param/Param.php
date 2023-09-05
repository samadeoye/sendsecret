<?php
namespace SendSecret\Param;

class Param
{
    //returns the expected parameters for each request with its respective validations
    public static function getRequestParams($action)
    {
        $data = [];
        switch($action)
        {
            case 'register':
                $data = [
                    'fname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'First Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'lname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Last Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'email' => [
                        'method' => 'post',
                        'length' => [13,100],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ],
                    'password' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Password',
                        'required' => true
                    ],
                    'passwordConfirm' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Confirm Password',
                        'required' => true
                    ]
                ];
            break;

            case 'login':
                $data = [
                    'email' => [
                        'method' => 'post',
                        'length' => [13,100],
                        'label' => 'Email',
                        'required' => true,
                        'type' => 'string',
                        'is_email' => true
                    ],
                    'password' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Password',
                        'required' => true
                    ]
                ];
            break;
            
            case 'updateProfile':
                $data = [
                    'fname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'First Name',
                        'required' => true,
                        'type' => 'string'
                    ],
                    'lname' => [
                        'method' => 'post',
                        'length' => [3,100],
                        'label' => 'Last Name',
                        'required' => true,
                        'type' => 'string'
                    ]
                ];
            break;

            case 'changePassword':
                $data = [
                    'oldPassword' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Old Password',
                        'required' => true
                    ],
                    'newPassword' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'New Password',
                        'required' => true
                    ],
                    'passwordConfirm' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Confirm Password',
                        'required' => true
                    ]
                ];
            break;

            case 'forgotPassword':
                $data = [
                    'email' => [
                        'method' => 'post',
                        'length' => [13,100],
                        'label' => 'Email',
                        'required' => true
                    ]
                ];
            break;

            case 'resetPassword':
                $data = [
                    'token' => [
                        'method' => 'post',
                        'length' => [36,36],
                        'label' => 'Token',
                        'required' => true
                    ],
                    'newPassword' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'New Password',
                        'required' => true
                    ],
                    'passwordConfirm' => [
                        'method' => 'post',
                        'length' => [6,0],
                        'label' => 'Password Confirm',
                        'required' => true
                    ]
                ];
            break;

            case 'encodeMessage':
                $data = [
                    'plainMsg' => [
                        'method' => 'post',
                        'length' => [5,500],
                        'label' => 'Message',
                        'required' => true
                    ],
                    'secretKey' => [
                        'method' => 'post',
                        'length' => [4,4],
                        'label' => 'Secret Key',
                        'required' => true
                    ]
                ];
            break;

            case 'decodeMessage':
                $data = [
                    'messageRef' => [
                        'method' => 'post',
                        'length' => [24,24],
                        'label' => 'Message Reference',
                        'required' => true
                    ],
                    'secretKey' => [
                        'method' => 'post',
                        'length' => [4,4],
                        'label' => 'Secret Key',
                        'required' => true
                    ]
                ];
            break;
        }

        return $data;
    }
}