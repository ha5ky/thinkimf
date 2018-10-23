var GM_JQ = document.createElement('script');
GM_JQ.src = '//code.jquery.com/jquery-3.3.1.min.js';
GM_JQ.type = 'text/JavaScript';
document.getElementsByTagName('head')[0].appendChild(GM_JQ);
$("input[disabled]").prop('disabled',0);

//下载视频
$('table a').each(function($k,$v){window.open(($($v).attr('href')))});

@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: url(fonts/opensans.eot);
    src: local('Open Sans'), local('OpenSans'), url(fonts/opensans.eot) format('embedded-opentype'), url(fonts/opensans.woff) format('woff');
}

@font-face {
    font-family: 'Open Sans';
    font-style: normal;
    font-weight: 400;
    src: url(https://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3fY6323mHUZFJMgTvxaG2iE.eot);
    src: local('Open Sans'), local('OpenSans'), url(https://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3fY6323mHUZFJMgTvxaG2iE.eot) format('embedded-opentype'), url(https://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3T8E0i7KZn-EPnyo3HZu7kw.woff) format('woff');
}