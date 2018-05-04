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
    var myCity = new BMap.LocalCity();
    myCity.get(UserDefaultLocation);

    function UserDefaultLocation(result) {
        var cityName = result.name;
        //map.setCurrentCity("北京");
        map.setCenter(cityName);
    }
    //隐藏底部版权
    $('.anchorBL').css('display','none');

});