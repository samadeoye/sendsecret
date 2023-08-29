function doOpenLogoutModal()
{
  Swal.fire({
    title: '',
    text: 'Are you sure you want to logout?',
    icon: 'error',
    showCancelButton: true,
    reverseButtons: true,
    confirmButtonText: 'Logout',
    confirmButtonColor: '#d33',
    }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'auth/logout';
    }
  });
}
function throwError(msg)
{
  toastr.error(msg);
}
function throwInfo(msg)
{
  toastr.info(msg);
}
function throwWarning(msg)
{
  toastr.warning(msg);
}
function throwSuccess(msg)
{
  toastr.success(msg);
}
function enableDisableBtn(id, status)
{
  disable = true;
  if(status == 1)
  {
    disable = false;
  }
  $(id).attr('disabled', disable);
  if(disable)
  {
    $(id).append(' <div class="spinner-border text-light spinner-border-sm" role="status"><span class="sr-only">Processing...</span></div>');
  }
  else
  {
    $('.spinner-border').remove();
  }
}