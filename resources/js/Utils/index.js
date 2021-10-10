export const handleError = (error) => {
   toaster('Somthing went wrong', 'Error', 'red', 'error');
}

export const handleSuccess = (message) => {
   toaster(message || 'Action was successfull');
}