<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#7e2afc";
}


function checkhexcolor2($secondColor){
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor OR !checkhexcolor2($secondColor)) {
    $secondColor = "#7e2afc";
}
?>


.text--base {
  color: <?php echo $color; ?> !important;
}

/* Btn Color */
.btn--outline {
  border: 1px solid <?php echo $color; ?>;
}

.btn--base {
  background: <?php echo $color; ?> !important;
  border-color: <?php echo $color; ?> !important;
}

.bg--base {
  background: <?php echo $color; ?> !important;
}
h1 a:hover,
h2 a:hover,
h3 a:hover,
h4 a:hover,
h5 a:hover,
h6 a:hover {
  color: <?php echo $color; ?>;
}
a:hover {
  color: <?php echo $color; ?>;
}
button {
  background: <?php echo $color; ?>;
}
.custom--checkbox input[type="checkbox"]::after {
  color: <?php echo $color; ?>;
}
.scrollToTop {
  background: <?php echo $color; ?>;
}
.cmn--btn {
  color: <?php echo $color; ?>;
}
.cmn--btn::before {
  background: <?php echo $color; ?>;
}
.cmn--btn::after {
  background: <?php echo $color; ?>;
}
.custom--badge {
  background: <?php echo $color; ?>;
}
.footer-bottom .footer-bottom-wrapper .social-icons li a:hover {
  background: <?php echo $color; ?>;
}
.recent-post-item .content .date i {
  color: <?php echo $color; ?>;
}
.cart-sidebar .close-cart:hover {
  background: <?php echo $color; ?>;
}

.blog-details-wrapper .meta-content li i {
  color: <?php echo $color; ?>;
}
.plan-bottom, .post-item .meta-date,.team-item .team-thumb::before , .plan-price , .work-icon ,.work-icon:before , .banner-section::before ,.plan-item .cmn--btn-2 , .inner-banner::before , div[class*='col']:nth-child(odd) .plan-serial, div[class*='col']:nth-child(odd) .post-item .read-more::before {
  background: linear-gradient(-40deg, <?php echo $secondColor; ?> 42%, <?php echo $color ?> 100%) !important ;
}

.post-content .read-more {
  background: linear-gradient(-40deg, <?php echo $secondColor; ?> 42%, <?php echo $color ?> 100%) ;
}
.plan-bottom .plan-body .plan-info li.active i , div[class*='col']:nth-child(odd) .plan-name {
  color:  <?php echo $secondColor; ?>;
}
.team-item  {
  background: linear-gradient(-40deg, <?php echo $secondColor; ?> 42%, <?php echo $color ?> 100%) !important ;
}
.plan-bottom .plan-body .plan-info li.active i {
  color: <?php echo $color; ?>;
}
.testimonial-item .designation {
  color: <?php echo $color; ?>;
}

.faq-item .faq-title::before, .faq-item .faq-title::after {
  background: <?php echo $color; ?>;
}
.faq-item .faq-content::before {
  background: <?php echo $color; ?>;
}
.product-details .owl-prev, .product-details .owl-next {
  background: <?php echo $color; ?> !important;
}

.product-info-wrapper .cmn--btn-2 {
  background: <?php echo $color; ?>;
}

.product-info-wrapper .product-variants .variants li.active {
  color: <?php echo $color; ?>;
}


.custom--table thead tr {
  background:<?php echo $color; ?>;
}

.widget-check-color input:checked + label::before {
  border: 2px solid<?php echo $color; ?>;
}

.product-details-wrapper .description .info-list li::before {
  color: <?php echo $color; ?>;
}

.cart-table tbody tr .price {
  color: <?php echo $color; ?>;
}

.section-header .title span {
  color: <?php echo $color; ?>;
}

.social-icons li a:hover {
  background: <?php echo $color; ?>;
  border-color: <?php echo $color; ?>;
}

.slick-dots li.slick-active button {
  background: <?php echo $color; ?>;
}

.slick-arrow:hover, .slick-arrow.arrow-right {
  background: <?php echo $color; ?>;
}
.menu.active {
    background: <?php echo $secondColor; ?>;
  }
  .dashboard-user .user-content .user-option li a {
  background: <?php echo $secondColor; ?>;
}
.user-dashboard-tab li a:hover, .user-dashboard-tab li a.active {
  border-color: <?php echo $secondColor; ?>;
  background: <?php echo $secondColor; ?>;
}
.menu.active {
    background: <?php echo $secondColor; ?>;
  }

  .text--primary {
  color: <?php echo $secondColor; ?>; !important;
}

.btn--primary {
  background: <?php echo $secondColor; ?>; !important;
  border-color: <?php echo $secondColor; ?>; !important;
}
.bg--primary {
  background: <?php echo $secondColor; ?>; !important;
}
.cmn--btn-2:hover {
  background: <?php echo $secondColor; ?>;
}
.header-bottom {
  background: <?php echo $secondColor; ?>;
}
  .sub-menu li a:hover {
    background: <?php echo $secondColor; ?>;
  }



.custom--card .card-header i {
  color: <?php echo $secondColor; ?>;
}

.custom--card .card-body .card-title {
  color: <?php echo $secondColor; ?>;
}
.footer-section, .transection-table thead tr {
  background: linear-gradient(270deg, <?php echo $color; ?> 0%, <?php echo $secondColor; ?> 50%);
}
.pagination .page-item.active span,
.pagination .page-item.active a, .pagination .page-item:hover span,
.pagination .page-item:hover a {
  background: <?php echo $secondColor; ?>;
}
.color-tooltip {
  background: <?php echo $secondColor; ?>;
}
.color-tooltip::before {
  background: <?php echo $secondColor; ?>;
}

.post-content .post-tag {
  background: <?php echo $secondColor; ?>;
}
.user-toggler-wrapper {
  background: <?php echo $secondColor; ?>;
}

.dashboard-user::before {
  background: <?php echo $secondColor; ?>;
}

.service-item {
  background: linear-gradient(-40deg, <?php echo $secondColor; ?> 42%, <?php echo $color ?> 100%) !important ;
}

.transection-table-tab-menu li a.active {
  background: <?php echo $secondColor; ?>;
}


.product-thumb .product-options li a {
  background: <?php echo $secondColor; ?>;
}

.product-content .add-to-cart {
  background: <?php echo $secondColor; ?>;
}

.cart-plus-minus .qtybutton.active, .cart-plus-minus .qtybutton:hover {
  background: <?php echo $secondColor; ?>;
}

.product-filter li.active {
  background: <?php echo $secondColor; ?>;
}

.section-header .subtitle {
  color: <?php echo $secondColor; ?>;
}


.section-header .subtitle::before {
  background: <?php echo $secondColor; ?>;
}

.mr-list__btn {
  border: 1px solid <?php echo $secondColor; ?>;
}

.mr-list__btn:hover {
  background: <?php echo $secondColor; ?>;
}
.mr-list__btn.active {
  background: <?php echo $secondColor; ?>;
}
.form--control:focus {
  background-color: #fff;
  border: 1px solid <?php echo $color; ?>;
}

.cookie-policy{
  background: <?php echo $secondColor; ?>;
}