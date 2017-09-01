<?php $indexc=1; if ($fn_include = $this->_include("header.html")) include($fn_include); ?>

<div class="blog-body">
    <div class="blog-container">
        <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
            <a href="/" title="网站首页">网站首页</a>
            <?php if ($parent) { ?>
                <a href="<?php echo $parent['url']; ?>"><?php echo $parent['name']; ?></a>
            <?php } ?>
            <a><cite>TAG: <?php echo $tag['name']; ?></cite></a>
        </blockquote>
        <div class="blog-main">
            <?php if ($tag['id']) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green"><?php echo $tag['name']; ?></span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php echo $tag['content']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="row">
                <!-- 调用全部内容模型,并循环输出相关内容数据 -->
                <?php $rt_c = $this->list_tag("action=cache name=module  return=c"); if ($rt_c) extract($rt_c); $count_c=count($return_c); if (is_array($return_c)) { foreach ($return_c as $key_c=>$c) { ?>
                <div class="col-md-6">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject"><a class="font-green" href="<?php echo $c['url']; ?>"><?php echo $tag['name']; ?>的<?php echo $c['name']; ?></a></span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="list-unstyled fc-list-row">
                                <!-- 调用$c['dirname']模型的相关tag内容 显示5条 -->
                                <?php $rt = $this->list_tag("action=related module=$c[dirname] field=title,url tag=$tag[tags] num=5"); if ($rt) extract($rt); $count=count($return); if (is_array($return)) { foreach ($return as $key=>$t) { ?>
                                <li><span class="badge badge-empty badge-success"></span> <a href="<?php echo $t['url']; ?>" class="title"><?php echo dr_strcut($t['title'], 35); ?></a></li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } } ?>
            </div>
        </div>
    </div>
</div>

<?php if ($fn_include = $this->_include("footer.html")) include($fn_include); ?>