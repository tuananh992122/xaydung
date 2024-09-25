<!-- Page Header Section Start Here -->
<div class="page-header-area">
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="header-page">
				<?=(isset($cat_name)?'<h1>'.$cat_name.'</h1>':'')?>
				<ul>
					<li> <a href="<?=PREFIX?>">Trang chủ</a> </li>
                    <?if(isset($parent)):?>
                    <li> <a href="<?=PREFIX.$pref.$parent->slug?>"><?=$parent->name?></a> </li>
                    <li><?=(isset($row)?$row->title:'')?></li>
                    <?else:?>
					<li><?=(isset($cat_name)?$cat_name:'')?></li>
                    <?endif;?>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<div class="main-news-page-section-area">
<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<div class="news-page-content-section-area">
                <?
                if(isset($kind) && $kind == "index"):?>
                <?if(isset($news)):
                    foreach($news as $n):
                ?>
				<div class="row single-news-area padding-top1">							
					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

						<div class="new-featured-image">
							<a href="<?=PREFIX.$n->slug.".html"?>">
								<img class="media-object" src="<?=PREFIX."uploads/news/thumb/".$n->thumb?>" alt="<?=$n->title?>">
							</a>       								
						</div>
					</div>

					<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">								  
						<div class="media-body news-body">
							<h3 class="media-heading"><a href="<?=PREFIX.$n->slug.".html"?>"><?=$n->title?></a></h3>
							<p class="meta"><?=date('d-m-Y',$n->time_create)?></p>
							<p class="news-content"><?=$n->caption?> </p>
							<div class="read-more">
								<a href="<?=PREFIX.$n->slug.".html"?>">Xem thêm  <i class="fa fa-angle-right" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>	

				</div>
				<?
                endforeach;
                endif;
                
                ?>
				<?elseif($kind == "details"):?>
                <div class="news-body">
                    <h1 class="page_title"><?=$row->title?></h1>
				    <p class="news-content"><?=$row->content?></p>
                    <p class="mata"><?=date('d-m-Y',$row->time_create)?>  / <?=$row->hits?> lượt xem</p>
				</div>
                <script type="application/ld+json">
                {
                  "@context": "http://schema.org/",
                  "@type": "Review",
                  "itemReviewed": {
                    "@type": "Thing",
                    "name": "<?=$row->title?>"
                  },
                  "author": {
                    "@type": "Person",
                    "name": "ThangPham"
                  },
                  "reviewRating": {
                    "@type": "Rating",
                    "ratingValue": "7",
                    "bestRating": "10"
                  },
                  "publisher": {
                    "@type": "Organization",
                    "name": "Huy Hoang"
                  }
                }
                </script>
                <?endif;?>
			</div>
			<div class="pagination-area">
				<ul>
					<?=(isset($pagi)?$pagi:'')?>
				</ul>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="page-sidebar-area">
                <?if(isset($list_cat)):?>
				<div class="single-sidebar padding-top1">
					<h3>Dịch vụ tiêu biểu</h3>
					<ul>
                        <?foreach($list_cat as $it_c):?>
						<li><a href="<?=PREFIX.'dich-vu/'.$it_c->slug?>"><?=$it_c->name?></a></li>
						<?endforeach;?>
					</ul>
				</div>
                <?endif;?>
                <?if(isset($list)):?>
				<div class="single-sidebar padding-top1">
					<h3>Bài viết nổi bật</h3>
					<ul>
                        <?foreach($list as $it):?>
						<li><a href="<?=PREFIX.$it->slug.".html"?>"><?=$it->title?></a></li>
						<?endforeach;?>
					</ul>
				</div>
                <?endif;?>
                <?if(isset($other)):?>
				<div class="single-sidebar padding-top1">
					<h3>Bài viết cùng loại</h3>
					<ul>
                        <?foreach($other as $ot):?>
						<li><a href="<?=PREFIX.$ot->slug.".html"?>"><?=$ot->title?></a></li>
						<?endforeach;?>
					</ul>
				</div>
                <?endif;?>
			</div>
		</div>
	</div>
</div>
</div>
