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
        title : "海底捞王府井店", // 信息窗口标题
        enableMessage:true,//设置允许信息窗发送短息
        message:"亲耐滴,晚上一起吃个饭吧？戳下面的链接看下地址喔~"
    }
    map.addOverlay(marker);              // 将标注添加到地图中
    var infoWindow = new BMap.InfoWindow("地址：北京市东城区王府井大街88号乐天银泰百货八层", opts);  // 创建信息窗口对象
    map.openInfoWindow(infoWindow,point2); //开启信息窗口
    marker.addEventListener("click", function(){
        this.openInfoWindow(infoWindow);
    });
    $citys = "北京,天津,石家庄,呼和浩特,太原,沈阳,大连,长春,哈尔滨,上海,南京,杭州,宁波,合肥,福州,厦门,南昌,济南,青岛,郑州,武汉,长沙,广州,深圳,南宁,海口,重庆,成都,贵阳,昆明,西安,兰州,西宁,银川,乌鲁木齐,唐山,秦皇岛,包头,丹东,锦州,吉林,牡丹江,无锡,苏州,扬州,徐州,温州,金华,蚌埠,安庆,,泉州九江,赣州,烟台,洛阳,平顶山,宜昌,襄樊,岳阳,常德,惠州,湛江,韶关,桂林,北海,三亚,泸州,南充,遵义,大理".split(',');
    //初始化70个点
    function addressToPoint(adds,$city){
        // 创建地址解析器实例
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint(adds, function(point){
            return point;
        },$city);
    }
    var pointArr = [];
    for(var i=0;i<$citys.length;i++){
        if($citys[i]){
            var $point = addressToPoint($citys[i],'北京');
            console.log($point)
            pointArr.push($point);
            // var marker = new BMap.Marker($point);
            // map.addOverlay(marker);    //添加标注
            // //添加信息窗口
            // var opts = {
            //     width : 200,     // 信息窗口宽度
            //     height: 100,     // 信息窗口高度
            //     title : '<b style="color:red;">信息提示</b>' , // 信息窗口标题
            // }
            // var infoWindow = new BMap.InfoWindow($citys[i],opts);  // 创建信息窗口对象
            // //map.openInfoWindow(infoWindow,pp); //开启信息窗口
            // marker.addEventListener("click", function(){
            //     this.openInfoWindow(infoWindow);
            // });
        }

    }
    var index = 0;
    var myGeo = new BMap.Geocoder();
    var adds = [
        "包河区金寨路1号（金寨路与望江西路交叉口）",
        "庐阳区凤台路209号（凤台路与蒙城北路交叉口）",
        "蜀山区金寨路217号(近安医附院公交车站)",
        "蜀山区梅山路10号(近安徽饭店) ",
        "蜀山区 长丰南路159号铜锣湾广场312室",
        "合肥市寿春路93号钱柜星乐町KTV（逍遥津公园对面）",
        "庐阳区长江中路177号",
        "新站区胜利路89"
    ];
    function bdGEO(){
        var add = adds[index];
        geocodeSearch(add);
        index++;
    }
    bdGEO();
    function geocodeSearch(add){
        if(index < adds.length){
            setTimeout(window.bdGEO,400);
        }
        myGeo.getPoint(add, function(point){
            if (point) {
                var address = new BMap.Point(point.lng, point.lat);
                addMarker(address,new BMap.Label(index+":"+add,{offset:new BMap.Size(20,-10)}));
            }
        }, "合肥市");
    }
    // 编写自定义函数,创建标注
    function addMarker(point,label){
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);
        marker.setLabel(label);
    }
    //隐藏底部版权
    $('.anchorBL').css('display','none');

});