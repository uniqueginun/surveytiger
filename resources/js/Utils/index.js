export const handleError = (error) => {
   toaster('Somthing went wrong', 'Error', 'red', 'error');
}

export const handleSuccess = (message) => {
   toaster(message || 'Action was successfull');
}

export const copyUrl = (str) => {
    if (!str) {
        return;
    }

    const el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style.position = 'absolute';
    el.style.left = '-9999px';
    document.body.appendChild(el);
    const selected =  document.getSelection().rangeCount > 0  ? document.getSelection().getRangeAt(0) : false;
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    if (selected) {
        document.getSelection().removeAllRanges();
        document.getSelection().addRange(selected);
    }

    toaster('Copied!', '');
}
