<div id="think_page_trace" style="position: fixed;bottom:0;right:0;font-size:14px;width:100%;z-index: 999999;color: #000;text-align:left;font-family:'微软雅黑';">
    <div id="think_page_trace_tab" style="display: none;background:white;margin:0;height: 250px;">
        <div id="think_page_trace_tab_tit" style="height:30px;padding: 6px 12px 0;border-bottom:1px solid #ececec;border-top:1px solid #ececec;font-size:16px">
            <?php foreach ($trace as $key => $value) {?>
            <span style="color:#000;padding-rights:12px;height:30px;line-height:30px;display:inline-block;margin-rights:3px;cursor:pointer;font-weight:700"><?php echo $key ?></span>
            <?php }?>
        </div>
        <div id="think_page_trace_tab_cont" style="overflow:auto;height:212px;padding:0;line-height: 24px">
            <?php foreach ($trace as $info) {?>
            <div style="display:none;">
                <ol style="padding: 0; margin:0">
                    <?php
                    if (is_array($info)) {
                        foreach ($info as $k => $val) {
                            echo '<li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">' . (is_numeric($k) ? '' : $k.' : ') . htmlentities(print_r($val,true), ENT_COMPAT, 'utf-8') . '</li>';
                        }
                    }
                    ?>
                </ol>
            </div>
            <?php }?>
        </div>
    </div>
    <div id="think_page_trace_close" style="display:none;text-align:right;height:15px;position:absolute;top:10px;right:12px;cursor:pointer;"><img style="vertical-align:top;" src="data:image/gif;base64,R0lGODlhDwAPAJEAAAAAAAMDA////wAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MUQxMjc1MUJCQUJDMTFFMTk0OUVGRjc3QzU4RURFNkEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MUQxMjc1MUNCQUJDMTFFMTk0OUVGRjc3QzU4RURFNkEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDoxRDEyNzUxOUJBQkMxMUUxOTQ5RUZGNzdDNThFREU2QSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDoxRDEyNzUxQUJBQkMxMUUxOTQ5RUZGNzdDNThFREU2QSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PgH//v38+/r5+Pf29fTz8vHw7+7t7Ovq6ejn5uXk4+Lh4N/e3dzb2tnY19bV1NPS0dDPzs3My8rJyMfGxcTDwsHAv769vLu6ubi3trW0s7KxsK+urayrqqmop6alpKOioaCfnp2cm5qZmJeWlZSTkpGQj46NjIuKiYiHhoWEg4KBgH9+fXx7enl4d3Z1dHNycXBvbm1sa2ppaGdmZWRjYmFgX15dXFtaWVhXVlVUU1JRUE9OTUxLSklIR0ZFRENCQUA/Pj08Ozo5ODc2NTQzMjEwLy4tLCsqKSgnJiUkIyIhIB8eHRwbGhkYFxYVFBMSERAPDg0MCwoJCAcGBQQDAgEAACH5BAAAAAAALAAAAAAPAA8AAAIdjI6JZqotoJPR1fnsgRR3C2jZl3Ai9aWZZooV+RQAOw==" /></div>
</div>
<div id="think_page_trace_open" style="height:30px;float:right;text-align:right;overflow:hidden;position:fixed;bottom:0;right:0;color:#000;line-height:30px;cursor:pointer;">
    <div style="background:#232323;color:#FFF;padding:0 6px;float:right;line-height:30px;font-size:14px"><?php echo \think\Container::get('debug')->getUseTime().'s ';?></div>
    <img width="60" style="" title="ShowPageTrace" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAAeCAYAAABwmH1PAAAFLElEQVR42u1YW2hcRRj+spvdPbubzW7S9UFRvD6IioJ4a1Pv9V4VQR+LIPZBfBC0goggCj4o6ouoLyqCICgiUm9IWqVG27pq1dQUjaGt1cZs093UJIrWNPr9OzMnk+mcs5tEKcU98MG5/DPzf9//zz8zB2hf7at9ta+j+OqIwZH0Zak8mhokNP5rATqOAA4jmfQg0aIIzcSIa5NYAFppG+X7vI+dGikLnRYWK0Ccg664nU2QjEAr7WS80FjIpYmMi1+Ba/cDF3pEaAw2AZzkESJS9T+Aq8eAkx2HUpYPPj/M+1QE4trN+TwLDBC/+HAHUKBR9m9grEbSvsE3A738fuhPYE2Equ67FO1rPwFnuw7y/W4z9iBwOt/leL/3EDAifhCBRtiG4z4q9j8CK7VNzsclJL4HOO4b4PgKcAIHPDDMSK6n+utVBPICNqiyxfXSme40aw88pqKfduAqn7aI1XYC51h9NfAA0MNv9WHVX5dACB8E3qwqQfPahxAUY5TYzv4u1m0KbDO1DTjP8HhfZWCgfWg4JY4EQngHcBFUZEMIYSq4WjpcBRSNENbAWScCIdYou8CoLxDCFPlcQ8pCQQh/BazgfTdRFML7gHsYyY36XejXOHAX379Owru2A5dB+SZtpph5F1j2eT1+xiYsqXuAqbRcG3UbCGEqeONfQP8M8C2fp6eYStpOolAdUlHJa0Jjo8A1tN1IZ4b4fXISeNASsP4ZIyDOUchbpf33wHXa2YmtKj17BEL4Y6CP/Yx/rkiVDDH6U2E2rOa3fV8CV/Bdr0AIf6QCZ2wLWuwgirAhaxSrsvPNTwInyjNTeC1tZ99Q86woA26bE6ogztF+02PAsSYSYv8icIo4IYQ/pEDipDj3A3CbRXDiE5We4vwyijZK51fWgaemgZcMKWbiLUz1itzL+FuAVWJPlKVPToH7Oe461p77WFTvxVymNQpJ2pPS8wjvBe7UijUco+3BQRWVkh6wz9gLYc75283zGaqwzZLglToC9X6OQzK7dym7ZQZCeBNwiXFeCH/A51c459nHzEPAqfLtd+At+nS32FiEy8QxfJ7myvI8s/A5wW/As5GEdcEo2KSFMKNwk01Yp/HNlsJ9+psIML5DzfmSaUP72qAqfEKqToffo/LPiIPa0bKOzgSjf6l5NoTFjhF+jZF75F36OKMqb9kQZlZcpftqEN6gMq7Hl9JmDcxYhMMiYuawRbjkIzxgzTuHsBGoxmJ0gyZVf4eFiSm5lev74zZpH+ENKsXLX7A9p8ow0/tptnvCJmxFuJHSmnBJB61LE87YG4+0EN6pqltOp4BZGhpFy6SonofV75QIPTERLhqR3AhzqVj+AnAWCYxwrj0sjp5G4lZKz5vDJuUp0qfsf/Jl4EzzTsav6OliitaAClzRqtLhspQwUabhfq7L51vLTE4v5NWfVXQKdtSHtQh6wBX2HB5R5LqtaVEbUnO+Ee1+VSt6pUDJM1N1HcntkXvB22qdDqu0yRRW/7WcDq+aZyP418DlpipL+4ri0eUsSSl7L+1uLwNr/cxaa27eSfkodHns7Opf8qDoQXeLcMfOW3uEjLW9DDfzLmnf3tQnQM7aiBy2E4qwayaWK1i+BeQ8GyF3L510j4fJiA193AY98CDjQeBkTa4Jsg6CFhB9aLBOSx0tnIl9xy2fEKkWEHWqiUI6Zp8eBd+xcN5ZfaEH8uQSEHdm9Tncylk47qdF7M+JpRzkF/NXIrGAPy2L+RPyr/yS6jhK0L7a1//h+gcPwMleG2o1KwAAAABJRU5ErkJggg==">
</div>

<script type="text/javascript">
    (function(){
        var tab_tit  = document.getElementById('think_page_trace_tab_tit').getElementsByTagName('span');
        var tab_cont = document.getElementById('think_page_trace_tab_cont').getElementsByTagName('div');
        var open     = document.getElementById('think_page_trace_open');
        var close    = document.getElementById('think_page_trace_close').children[0];
        var trace    = document.getElementById('think_page_trace_tab');
        var cookie   = document.cookie.match(/thinkphp_show_page_trace=(\d\|\d)/);
        var history  = (cookie && typeof cookie[1] != 'undefined' && cookie[1].split('|')) || [0,0];
        open.onclick = function(){
            trace.style.display = 'block';
            this.style.display = 'none';
            close.parentNode.style.display = 'block';
            history[0] = 1;
            document.cookie = 'thinkphp_show_page_trace='+history.join('|')
        }
        close.onclick = function(){
            trace.style.display = 'none';
            this.parentNode.style.display = 'none';
            open.style.display = 'block';
            history[0] = 0;
            document.cookie = 'thinkphp_show_page_trace='+history.join('|')
        }
        for(var i = 0; i < tab_tit.length; i++){
            tab_tit[i].onclick = (function(i){
                return function(){
                    for(var j = 0; j < tab_cont.length; j++){
                        tab_cont[j].style.display = 'none';
                        tab_tit[j].style.color = '#999';
                    }
                    tab_cont[i].style.display = 'block';
                    tab_tit[i].style.color = '#000';
                    history[1] = i;
                    document.cookie = 'thinkphp_show_page_trace='+history.join('|')
                }
            })(i)
        }
        parseInt(history[0]) && open.click();
        tab_tit[history[1]].click();
    })();
</script>
