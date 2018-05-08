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


    //渲染20个数据点

    var point2 = new BMap.Point(116.417854,39.921988);
    var marker = new BMap.Marker(point2);  // 创建标注
    var opts = {
        width : 200,     // 信息窗口宽度
        height: 100,     // 信息窗口高度
        title : "海底捞王府井店" , // 信息窗口标题
        enableMessage:true,//设置允许信息窗发送短息
        message:"亲耐滴，晚上一起吃个饭吧？戳下面的链接看下地址喔~"
    }
    map.addOverlay(marker);              // 将标注添加到地图中
    var infoWindow = new BMap.InfoWindow("地址：北京市东城区王府井大街88号乐天银泰百货八层", opts);  // 创建信息窗口对象
    map.openInfoWindow(infoWindow,point2); //开启信息窗口
    marker.addEventListener("click", function(){
        this.openInfoWindow(infoWindow);
    });


    //隐藏底部版权
    $('.anchorBL').css('display','none');

});