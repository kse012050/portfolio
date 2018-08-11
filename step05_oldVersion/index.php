<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>SE</title>

    <!--jquery lode-->
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!--bxSlider-->
    <script src="js/jquery.bxslider.min.js"></script>
    <link href="css/jquery.bxslider.css" rel="stylesheet" />

    <!-- favicon Error -->
    <link rel="shortcut icon" href="#" />

    <!--jquery cookie-->
    <script src="js/jquery.cookie.js"></script>

    <script src="https://use.fontawesome.com/611ab86bce.js"></script>

    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
    <link href="css/import.css" rel="stylesheet" />
    <script>
        $(document).ready(function () {
            // 톱니 icon spin
            $('.fontaArea div:last-of-type > i:first-of-type').hover(function () {
                $(this).addClass('fa-spin');
            }, function () {
                $(this).removeClass('fa-spin');
              });

            // 로그인
            $('.fontaArea div:last-of-type > i:first-of-type').click(function () {

                 $.ajax({
                    type: "POST",
                    url: 'common/config.php',
                    dataType: 'json',
                    success: function (args) {
                        var item = args.list[0];
                        var password = item["password"];
                        alert('비밀번호  0' + password +'\n로그인은 10분동안 지속됩니다');
                        // cookie 값 시간
                        var date = new Date();
                        date.setTime(date.getTime() + 1 *600* 1000);

                        var passwordNumber = prompt('비밀번호를 입력해주세요', '01092931656');
                        if (passwordNumber == '0' + password) {
                            $('.fontaArea div:last-of-type > i').css('display', 'block');
                            $('.fontaArea div:last-of-type > i:first-of-type').css('display', 'none');
                            $('.collArea li figure span').removeClass('collSpanHover')
                            $('.collArea li figure span:last-of-type').addClass('collSpanHover');
                            $.cookie('LOGIN', '1', { expires: date });
                            location.reload();
                        } else if (passwordNumber == null) {
                         // 취소 버튼을 눌렀을 때 null을 반영한다
                        } else {
                            alert('비밀번호가 틀렸습니다');
                        }
                    }, error: function (e) {
                        alert('이런일은 없이');
                    }
                });
             });

            // 추가버튼
            $('.fontaArea div:last-of-type > i:nth-of-type(2)').hover(function () {
                $(this).addClass('fa-spin');
            }, function () {
                $(this).removeClass('fa-spin');
                });
            $('.fontaArea div:last-of-type > i:nth-of-type(2)').click(function () {
                $('.addArea_bg').css('display', 'block');
            });

            // 추가페이지에서 바탕클릭시 종료?
            var addAreaBg;
            $('.addArea').mouseover(function () {
                addAreaBg = true;
            });
            $('.addArea').mouseout(function () {
                addAreaBg = false;
            })
            $('.addArea_bg').click(function () {
                if (addAreaBg) {
                } else {
                    $('.addArea_bg').css('display', 'none');
                }

            });


            //관리자 페이지 닫기
            $('#managerClose').click(function () {
                $('.addArea_bg').css('display', 'none');
            });

            $('.fontaArea div:last-of-type > i:last-of-type').click(function () {
                var confirmTest = confirm('로그아웃 하시겠습니까?');
                if (confirmTest) {
                    $('.fontaArea div:last-of-type > i').css('display', 'none');
                    $('.fontaArea div:last-of-type > i:first-of-type').css('display', 'block');
                    $('.collArea li figure span').addClass('collSpanHover')
                    $('.collArea li figure span:last-of-type').removeClass('collSpanHover');
                    $.cookie("LOGIN", "");
                    alert($.cookie('LOGIN'));
                    location.reload();
                } else {}
            });

            // 로그인 쿠키
            if ($.cookie('LOGIN') == 1) {
                $('.fontaArea div:last-of-type > i').css('display', 'block');
                $('.fontaArea div:last-of-type > i:first-of-type').css('display', 'none');
                $('.collArea li figure span').removeClass('collSpanHover')
                $('.collArea li figure span:last-of-type').addClass('collSpanHover');
            } else {
                $('.fontaArea div:last-of-type > i').css('display', 'none');
                $('.fontaArea div:last-of-type > i:first-of-type').css('display', 'block');
                $('.collArea li figure span').addClass('collSpanHover')
                $('.collArea li figure span:last-of-type').removeClass('collSpanHover');
            }

            //popup01 팝업 / 쿠키
            $('#popup01_Close').click(function () {
                $('.popup01').css('display', 'none');
            });

            var popupDate = new Date();
            popupDate.setTime(popupDate.getTime() + 1 * 10 * 1000);

            $('#popup01_OneHourClose').click(function () {
                $.cookie('popup01', '1', { expires: 1 });
                $('.popup01').css('display', 'none');
            });
            if ($.cookie('popup01') == 1) {
                $('.popup01').css('display', 'none');
            }

            // 이미지 미리보기
            var file = document.querySelector('#addImg');
            file.onchange = function () {
                var fileList = file.files;
                // 읽기
                var reader = new FileReader();
                reader.readAsDataURL(fileList[0]);
                //로드 한 후
                reader.onload = function () {
                    document.querySelector('#PreviewImg').src = reader.result;
                };
            }; 

            // 추가
            $('#managerInsert').click(function () {
                if ($.trim($("#addTitle").val()) == "") {
                    alert("제목을 입력해 주십시요.");
                    $('#addTitle').focus();
                    return false;
                } else if ($.trim($("#addURL").val()) == "") {
                    alert("URL를 입력해 주십시요.");
                    $('#addURL').focus();
                    return false;
                } else if ($("#addImg").val() == "") {
                    alert("썸네일 이미지를 입력해 주십시요.");
                    $('#addImg').focus();
                    return false;
                } else {
                    $.ajax({
                        type: "POST",
                        url: 'common/insert.php',
                        dataType: 'json',
                        data: FormData,
                        success: function (args) {
                            alert('성공');
                            location.reload();
                        },
                        error: function (e) {

                        }
                    }).submit();
                }
            });

            //텝 옵션으로 슬라이더와 리스트
            $('.tab_content').hide();
            $('.tab_content:first-of-type').show();
            $('.tabs i').click(function () {
                $('.tabs i').css('color', 'white');
                $(this).css('color', '#fdd75c');
                $('.tab_content').hide();
                var activeTab = $(this).attr('rel');
                $('#' + activeTab).fadeIn();
            });

            // 리스트형에서 창을 줄이고 슬라이더로 넘어왔을때 슬라이더가 없어지는 것을 잡아주기 위한
            $('.fontaArea div i.fa-th-large').click(function () {
                location.reload();
            });
       
            
            // db 내용 가져와서 html 넣기
            makeColl();

            // slider 데이터 가져오기
            function makeColl() {
                $('.collBxslider').empty();
                $('.collectionList').empty();
                // .collBxslider // .collectionList 안에 있는 내용 지우기 ?
                

                var bxSliderVar;

                $.ajax({
                    type: "POST",
                    url: 'common/selectCollSlider.php',
                    data: 'json',
                    success: function (args) {
                        for (var i = args.count - 1; i > 0; i--) {
                            var item = args.list[i];

                            var seq = item["seq"];
                            var title = item["title"];
                            var link = item["link"];;
                            var thumb_saved = item["thumb_saved"];

                            //URL을 올릴떄 http:// 을 올리지 않아도 검사를 통해 http:// 가 없으면 넣어주는 조건식과 if문                          
                            var urlCheck = /^((http(s?))\:\/\/)([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(\/\S*)?$/;
                            if (urlCheck.test(link) == false) {
                                link = "http://" + link;
                            };

                            // 쿠키 LOGIN에 따라 삭제할 것인지 이동할 것인지 조절?
                            if ($.cookie('LOGIN') == 1) {
                                var html = "<li class='deleteLi'>";
                                html = html + "<figure>";
                                html = html + "<div>"
                                html = html + "<span> <i class='fa fa-plus'></i> </span>";
                                html = html + "<span class='collSpanHover'> <i class='fa fa-minus'></i> </span>";
                                html = html + "<img src='thum/" + thumb_saved + "' alt='' id = 'thumb" + i + "' />";
                                html = html + "</div>"
                                html = html + "<figcaption>";
                                html = html + "<dl>";
                                html = html + "<dt>" + title + "</dt >";
                                html = html + "</dl>";
                                html = html + "<a href='#' onclick='collectionDelete(" + seq + ");' title='삭제하기'></a>";
                                html = html + "<input type='hidden' id='caseStudyDetailSeq' name='caseStudyDetailSeq' />";
                                html = html + "</figcaption>";
                                html = html + "</figure>";
                                html = html + "</li>";

                                var listHtml = "<li class='deleteLi'><a href='#' onmouseover='onMouseList(" + i + ")'  onclick='collectionDelete(" + seq + ");' ></a>" + title + "</li>"
                            } else {
                                var html = "<li>";
                                html = html + "<figure>";
                                html = html + "<div>"
                                html = html + "<span class='collSpanHover'> <i class='fa fa-plus'></i> </span>";
                                html = html + "<span> <i class='fa fa-minus'></i> </span>";
                                html = html + "<img src='thum/" + thumb_saved + "' alt='' id = 'thumb" + i +"' />";
                                html = html + "</div>"
                                html = html + "<figcaption>";
                                html = html + "<dl>";
                                html = html + "<dt>" + title + "</dt >";
                                html = html + "</dl>"
                                html = html + "<a href=" + link + " target='_blank' title='이동하기'></a>"
                                html = html + "</figcaption>"
                                html = html + "</figure>"
                                html = html + "</li>"

                                var listHtml = "<li><a href=" + link + " onmouseover='onMouseList(" + i + ")' target='_blank'></a>" + title + "</li>"
                            }
                            $('.collBxslider').append(html);
                            $('.collectionList').append(listHtml);

                            // 리스트 형에서 가장 최근 올린 이미지를 가장 먼저 보여주기
                            if (args.count > 0) {
                                var countTest = args.count - 1;
                                var imgSrc = $("#thumb" + countTest).attr('src');
                                $('#listImg').attr('src', imgSrc);
                            }

                        }

                        //슬라이더 창의 width에 따라 보여지는 객체 조절
                        var w = $(window).width();
                        if (bxSliderVar == null || bxSliderVar == "undefined") {

                            if (w <= 767) {
                                bxSliderVar = $('.collBxslider').bxSlider({
                                    mode: 'horizontal', //default : 'horizontal', options: 'horizontal', 'vertical', 'fade'
                                    minSlides: 2,
                                    maxSlides: 2,
                                    slideWidth: 320,
                                    slideMargin: 10,
                                    infiniteLoop: false,
                                    hideControlOnEnd: true
                                });
                            } else {
                                bxSliderVar = $('.collBxslider').bxSlider({
                                    mode: 'horizontal', //default : 'horizontal', options: 'horizontal', 'vertical', 'fade'
                                    minSlides: 2,
                                    maxSlides: 4,
                                    slideWidth: 320,
                                    slideMargin: 10,
                                    infiniteLoop: false,
                                    hideControlOnEnd: true
                                });
                            }
                        } else {
                            if (w <= 767) {
                                bxSliderVar.reloadSlider({
                                    mode: 'horizontal', //default : 'horizontal', options: 'horizontal', 'vertical', 'fade'
                                    minSlides: 2,
                                    maxSlides: 2,
                                    slideWidth: 320,
                                    slideMargin: 10,
                                    infiniteLoop: false,
                                    hideControlOnEnd: true
                                    //nextSelector: '.next',
                                    //prevSelector: '.prev',
                                    //nextText: '>',
                                    //prevText: '<',
                                });
                            } else {
                                bxSliderVar.reloadSlider({
                                    mode: 'horizontal', //default : 'horizontal', options: 'horizontal', 'vertical', 'fade'
                                    minSlides: 2,
                                    maxSlides: 4,
                                    slideWidth: 320,
                                    slideMargin: 10,
                                    infiniteLoop: false,
                                    hideControlOnEnd: true
                                    //nextSelector: '.next',
                                    //prevSelector: '.prev',
                                    //nextText: '>',
                                    //prevText: '<',
                                });
                            }
                        }



                    }, error: function (e) {
                        alert('데이터 가져오기 실패');
                    }
                });        
            }
            
        });

        //리스트형에서 마우스오버시 해당 이미지 보여주기
        function onMouseList(idx) {
            var imgSrc = $("#thumb" + idx).attr("src");
            $("#listImg").attr("src", imgSrc);
        }

        // 게시물 삭제 ajax
        function collectionDelete(seq) {
            if (confirm('삭제하시겠습니까?')) {
                if (seq <= 6) {
                    alert('삭제할 수 없는 게시물 입니다');
                } else {
                    $.ajax({
                        type: "POST",
                        url: 'common/delete.php',
                        dataType: 'json',
                        data: /*{ seq: testTest }*/"seq=" + seq,
                        success: function (args) {
                            alert("정상적으로 삭제 되었습니다.");
                            //alert(seq);
                            //location.href = 'common/delete.php';
                            location.reload();
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    })
                }
            }
        };

    </script>
</head>
<body>
    <div>
        <h1>KSE <span>collection</span></h1>
        <p id="test01" class="asd">이곳은 지금까지 만들었던 사이트를 보여주는 공간입니다.</p>
        
        <div class="fontaArea">
            <div class="tabs">
                <!--나열 icon-->
                <i rel="tab2" class="fa fa-th-list" title="리스트"></i>
                <!--bxslider icon-->
                <i rel="tab1" class="fa fa-th-large" title="슬라이더"></i>
            </div>
            <div>
                <!--로그인 전 icon-->
                <i class="fa fa-cog" id="test" title="로그인"></i>
                <!--로그인 후 icon-->
                <i class="fa fa-plus" title="추가"></i>
                <i class="fa fa-sign-out" title="로그아웃"></i>
            </div>
        </div>
        <!--관리자 페이지-->
        <div class="addArea_bg">
             <section class="addArea mCustomScrollbar" >
                 <form method="post" action="common/insert.php"  enctype="multipart/form-data">
                     <fieldset>
                      <legend>collection 관리자 페이지</legend>
                         <ul>
                             <li>
                                 <label for="addTitle">제 목</label>
                                 <input type="text" id="addTitle" name="addTitle" />
                             </li>
                             <li>
                                 <label for="addURL">URL</label>
                                 <input type="text" id="addURL" name="addURL"/>
                             </li>
                             <li>
                                 <label for="addImg">썸네일 크기 320 x 306 pixels</label>
                                 <input type="file" id="addImg" name="addImg"/>
                             </li>
                             <li>
                                 <img src="" alt="" id="PreviewImg" />
                             </li>
                             <li>
                                 <input type="submit" value="저장" id="managerInsert"/>
                                 <input type="button" value="닫기" id="managerClose" />
                             </li>
                         </ul>
                     </fieldset>
                 </form>
             </section>
        </div>

        <div id="tab_container">
            <div id="tab1" class="tab_content">
            <div class="controlArea">
                <a href="" class="prev"></a>
                <a href="" class="next"></a>
            </div>
                <ul class="collArea collBxslider">
                    <li>
                        <figure>
                            <span class="collSpanHover">+</span>
                            <span>x</span>
                            <img src="images/portfolio_2.jpg" alt="portfolio_2" />
                            <figcaption>
                                <dl>
                                    <dt>Chopper</dt>
                                    <dd>원페이지</dd>
                                </dl>
                                <a href="#"></a>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/portfolio_3.jpg" alt="" />
                            <figcaption>
                                <dl>
                                    <dt></dt>
                                    <dd></dd>
                                </dl>
                                <a href=""></a>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/portfolio_2.jpg" alt="" />
                            <figcaption>
                                <dl>
                                    <dt></dt>
                                    <dd></dd>
                                </dl>
                                <a href=""></a>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/portfolio_3.jpg" alt="" />
                            <figcaption>
                                <dl>
                                    <dt></dt>
                                    <dd></dd>
                                </dl>
                                <a href=""></a>
                            </figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/portfolio_3.jpg" alt="" />
                            <figcaption>
                                <dl>
                                    <dt></dt>
                                    <dd></dd>
                                </dl>
                                <a href=""></a>
                            </figcaption>
                        </figure>
                    </li>
                </ul>
            </div>
            <div id="tab2" class="tab_content">
                <figure>
                    <div>
                        <img src="images/portfolio_2.jpg" id="listImg" alt="" />
                    </div>
                    <figcaption class="mCustomScrollbar">
                        <ul class="collectionList">
                            <li><a href="#"></a>chopper</li>
                            <li><a href="#"></a>MADMAX(분노의도로)</li>
                            <li><a href="#"></a>PR(Sung Eun Kim)</li>
                            <li><a href="#"></a>1</li>
                            <li><a href="#"></a>chopper</li>
                            <li><a href="#"></a>MADMAX(분노의도로)</li>
                            <li><a href="#"></a>PR(Sung Eun Kim)</li>
                            <li><a href="#"></a>1</li>
                            <li><a href="#"></a>chopper</li>
                            <li><a href="#"></a>MADMAX(분노의도로)</li>
                            <li><a href="#"></a>PR(Sung Eun Kim)</li>
                            <li><a href="#"></a>1</li>
                        </ul>
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>

    <section class="popup01">
        <p><i class="fa fa-cog fa-spin"></i>(로그인) 버튼을 눌러 로그인 후 컨텐츠 추가/삭제가 가능합니다.</p>
        <ul>
            <li><input type="button" value="하루동안 보지 않기" id="popup01_OneHourClose"/></li>
            <li><input type="button" value="닫기" id="popup01_Close" /></li>
        </ul>
        <!-- popup01_Close() popup01_OneHourClose()  -->
    </section>

    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

</body>
</html>