function ajaxRequest(requestURL, requestData, successFunc, errorFunc) {
    $.ajax({
        type: 'POST',
        url: requestURL,
        data: requestData,
        dataType: 'json',
        timeout: 0,
        success: function(result){
            if (result.Code == 0) {
                successFunc(result)
            } else {
                if (errorFunc) {
                    errorFunc(result)
                }
            }
        },
        error: function(xhr, type){
            alert('网络请求异常');
        },
        complete: function () {
            // ele.attr('disabled', false)
        }
    })
}