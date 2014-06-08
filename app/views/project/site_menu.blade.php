<ul class="nav nav-tediums">
    @if (isset($baseInfo))
    <?php $siteMenuActive = DomainSpall::setSiteMenuActive('class="active"'); ?>
    <li <?php echo $siteMenuActive[ProjectEnum::MENU_KEY_SITE_MODIFY]; ?>>
        <a href="#base-pane">基本信息</a>
    </li>
    <li <?php echo $siteMenuActive[ProjectEnum::MENU_KEY_SITE_TEAM]; ?>>
        <a href="#team-pane">团队成员</a>
    </li>
    <li <?php echo $siteMenuActive[ProjectEnum::MENU_KEY_ALERT_SHOWCONFIG]; ?>>
        <a href="/alert/showconfig/site/{{$baseInfo->domain_id}}">告警策略</a>
    </li>
    <li <?php echo $siteMenuActive[ProjectEnum::MENU_KEY_ALERT_SHOWCHANNEL]; ?>>
        <a href="#alert-pane">报警通道</a>
    </li>
    <li <?php echo $siteMenuActive[ProjectEnum::MENU_KEY_SITE_REMOVE]; ?>>
        <a href="#del-pane">删除网站监控</a>
    </li>

    @else
    <li class="active"><a href="#base-pane" data-toggle="tab">基本信息</a></li>
    @endif
</ul>