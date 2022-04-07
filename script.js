let formData = new FormData();
let toggleValue = 1;
let error = $('.error');
let errorList = [];

$(document).ready(function () {
    console.log(document.cookie);
})

function prepareDataForSignUp() {
    let formReg = $('.form_reg');
    let domain = formReg[0]['domain'].value;
    let login = formReg[0]['login'].value;
    let password = formReg[0]['password'].value;
    let repeatPassword = formReg[0]['repeat_password'].value;
    let rememberMe = formReg[0]['remember_me'].checked;

    formData.append('domain', domain);
    formData.append('login', login);
    formData.append('password', password);
    formData.append('repeatPassword', repeatPassword);
    formData.append('rememberMe', rememberMe);

    return true;

}

function prepareDataForSignIn() {
    let formAuth = $('.form_auth');
    let domain = formAuth[0]['domain'].value;
    let login = formAuth[0]['login'].value;
    let password = formAuth[0]['password'].value;
    let rememberMe = formAuth[0]['remember_me'].checked;

    formData.append('domain', domain);
    formData.append('login', login);
    formData.append('password', password);
    formData.append('rememberMe', rememberMe);

    return true;
}

$('.toggle').click(function () {
    let toggle = $('.toggle');
    if (toggleValue) {
        toggle.text('signup');
        $('.signup-wrapper').hide();
        $('.signin-wrapper').show();
        toggleValue = 0
    } else {
        toggle.text('signin');
        $('.signup-wrapper').show();
        $('.signin-wrapper').hide();
        toggleValue = 1
    }
});


$('.submitReg').click(function () {
    if (prepareDataForSignUp()) {
        submitAjax('https://localhost/auth/api/v1/signup/')
    }
})

$('.submitAuth').click(function () {
    if (prepareDataForSignIn()) {
        submitAjax('https://localhost/auth/api/v1/signin/')
    }
})

function visibleCode(data) {
    console.log(data);
    if(data.length == undefined) {
        error.text(Object.values(data));
    } else {
        data.map( (value) => {
            errorList.push(Object.values(value)[0]);
        })
    }
        errorList.map(value => {
            error.text(value);
            errorList.shift();
        })
}

function submitAjax(url) {
    $.ajax(url, {
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        success(data) {
            console.log(data);
            console.log(document.cookie);
            console.log(JSON.parse(data));
            visibleCode(JSON.parse(data));
        },
        error() {
            console.log('error');
        }
    }).then(console.log(document.cookie))
}
