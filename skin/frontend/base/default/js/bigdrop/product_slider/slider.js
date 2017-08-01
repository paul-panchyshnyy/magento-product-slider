/**
 * Custom Product Sliders
 * Default template
 *
 * @category Bigdrop
 * @package  Bigdrop_ProductSlider
 * @author   Pavel Panchyshnyy <pavel.p@bigdropinc.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$j(document).ready(function () {
    var sliders = $j('.product-slider');
    if (sliders.length) {
        sliders
            .on('init', function(slick) {
                var alignProductGridActions = function () {
                    $j('.product-slider').each(function(){
                        var gridRows = [];
                        var tempRow = [];
                        var products = $j(this).find('li.item');
                        products.each(function (index) {
                            if ($j(this).css('clear') != 'none' && index != 0) {
                                gridRows.push(tempRow);
                                tempRow = [];
                            }
                            tempRow.push(this);

                            if (products.length == index + 1) {
                                gridRows.push(tempRow);
                            }
                        });

                        $j.each(gridRows, function () {
                            var tallestProductInfo = 0;
                            $j.each(this, function () {
                                $j(this).find('.product-info').css({
                                    'min-height': '',
                                    'padding-bottom': ''
                                });

                                var productInfoHeight = $j(this).find('.product-info').height();
                                var actionSpacing = 10;
                                var actionHeight = $j(this).find('.product-info .actions').height();

                                var totalHeight = productInfoHeight + actionSpacing + actionHeight;
                                if (totalHeight > tallestProductInfo) {
                                    tallestProductInfo = totalHeight;
                                }

                                $j(this).find('.product-info').css('padding-bottom', actionHeight + 'px');
                            });
                            $j.each(this, function () {
                                $j(this).find('.product-info').css('min-height', tallestProductInfo);
                            });
                        });
                    });
                };
                alignProductGridActions();
                $j(slick.target.parentElement).css({'visibility': 'visible'});
            })
            .slick({
            slidesToShow: 5,
            slidesToScroll: 3,
            swap: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
});