$(function () {
    // 百度地图API功能
    var map = new BMap.Map("cloudMap",{mapType:BMAP_HYBRID_MAP});// 创建Map实例
    //map.setMapStyle({style: 'googlelite'}); //设置google风格模板
    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
    //map.disableDragging();
    map.centerAndZoom(new BMap.Point(103.388611,35.563611), 5);
    map.addControl(new BMap.MapTypeControl({
        mapTypes:[
            BMAP_SATELLITE_MAP,
            BMAP_HYBRID_MAP,
            BMAP_PERSPECTIVE_MAP
        ]}));
    //根据ip定位
    // var myCity = new BMap.LocalCity();
    // myCity.get(UserDefaultLocation);
    function UserDefaultLocation(result) {
        var cityName = result.name;
        //map.setCurrentCity("北京");
        map.setCenter(cityName);
    }
    // 编写自定义函数,创建标注, 且绑定点击事件
    function addMarkerWithClick(poi,label,infoString){
       // console.log(poi,label,infoString);
        var poiObj  = JSON.parse(poi);
        var bdPointer =  new BMap.Point(poiObj.lng,poiObj.lat)
        //console.log(poiObj);
        var myIcon = new BMap.Icon("/static/images/cloud/markicon24px.png", new BMap.Size(24,24));
        var marker = new BMap.Marker(bdPointer,{icon:myIcon});
        map.addOverlay(marker);
        marker.setLabel(label);
        map.addOverlay(marker);              // 将标注添加到地图中
        var opts = {

            title :'设备名称:'+label, // 信息窗口标题
        }
        var infoWindow = new BMap.InfoWindow(infoString, opts);  // 创建信息窗口对象
        //map.openInfoWindow(infoWindow,bdPointer); //开启信息窗口
        marker.addEventListener("click", function(){
            this.openInfoWindow(infoWindow);
        });
    }
    function initCloudDevice(type){
        if(type == 'pulling'){
            setInterval(function () {
                $.get('/api/device/cloudlist',{
                },function (d) {
                    if(d.code == 200){
                        // layui.use(['layer'], function () {
                        //     var layer = layui.layer;
                        //     layer.msg('获取设备列表成功!');
                        // });
                        map.clearOverlays();
                        $.each(d.data,function ($k,$v) {
                            //点渲染
                            var $infoString = '';
                            $infoString += '设备描述:'+$v.desc + '<br/>';
                            $infoString += '设备版本: '+$v.version + '<br/>';
                            $infoString += '设备地点:'+$v.location + '<br/>';
                            $infoString += '即使消息:'+'' + '<br/>';
                            $infoString += '<a class="layui-btn layui-btn-radius layui-btn-normal" target="_blank" href="/portal/cloud/devicedetail?device_id='+$v.device_id+'">设备详情</a><br/>';
                            addMarkerWithClick($v.baidu_map_poi,$v.device_name,$infoString);
                        });
                    }else{
                        // layui.use(['layer'], function () {
                        //     var layer = layui.layer;
                        //     layer.msg('获取不到设备');
                        // });
                    }
                });
            },3000);
        }
        if(type == 'cloud'){

        }
    }
    initCloudDevice('pulling');
    //隐藏底部版权
    $('.anchorBL').css('display','none');

});