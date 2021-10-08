export const handleError = (error) => {
   const { data, status, statusText } = error.response;
   toaster(data?.message || 'Somthing went wrong', statusText, 'red', 'error');
}

export const handleSuccess = (message) => {
   toaster(message || 'Action was successfull', 'Success', 'green', 'success');
}