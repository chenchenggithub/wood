<ul class="nav nav-pills">
    <?php $siteMenuActive = DomainSpall::setAlertMenuActive('class="active"'); ?>

    <li <?php echo $siteMenuActive[ProjectEnum::MENU_KEY_ALERT_SHOWCONFIG_SITE]; ?>>
        <a href="/alert/showconfig/site/{{$baseInfo->domain_id}}">网站整体告警设置</a>
    </li>
    <li <?php echo $siteMenuActive[ProjectEnum::MENU_KEY_ALERT_SHOWCONFIG_NET]; ?>>
        <a href="/alert/showconfig/net/{{$baseInfo->domain_id}}">网络告警设置</a>
    </li>
    <li <?php echo $siteMenuActive[ProjectEnum::MENU_KEY_ALERT_SHOWCONFIG_PAGE]; ?>>
        <a href="/alert/showconfig/page/{{$baseInfo->domain_id}}">整体告警设置</a>
    </li>
</ul>