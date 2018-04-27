var GM_JQ = document.createElement('script');
GM_JQ.src = 'http://ajax.aspnetcdn.com/ajax/jQuery/jQuery-1.7.2.js';
GM_JQ.type = 'text/JavaScript';
document.getElementsByTagName('head')[0].appendChild(GM_JQ);
$(":disabled").prop('disabled',0);

//下载视频
$('table a').each(function($k,$v){window.open(($($v).attr('href')))});