//<?php

class hook278 extends _HOOK_CLASS_
{

    /* !Hook Data - DO NOT REMOVE */
public static function hookData() {
 return array_merge_recursive( array (
  'topicRow' => 
  array (
    0 => 
    array (
      'selector' => 'li.ipsDataItem.ipsDataItem_responsivePhoto[itemtype=\'http://schema.org/Article\'] > ul.ipsDataItem_stats > li',
      'type' => 'replace',
      'content' => '
<li {{if $k == \'num_views\'}}class=\'ipsType_light\'{{elseif in_array( $k, $row->hotStats )}}class="ipsDataItem_stats_hot" data-text=\'{lang="hot_item"}\' data-ipsTooltip title=\'{lang="hot_item_desc"}\'{{endif}}>
  
  {{if $k == \'forums_comments\'}}
      <a href=\'{url="app=forums&module=forums&controller=topic&id=$row->tid&do=userStats" seoTemplate="forums_topic"}\' class="ipsType_blendLinks" data-ipsHover data-ipsHover-target=\'{url="app=forums&module=forums&controller=topic&id=$row->tid&do=userStats" seoTemplate="forums_topic"}\' data-ipsHover-width="325" data-ipsHover-onClick="true">
  {{endif}}

  <span class=\'ipsDataItem_stats_number\' {{if $k == \'forums_comments\' OR $k == \'answers_no_number\'}}itemprop=\'commentCount\'{{endif}}>{number="$v"}</span>
  <span class=\'ipsDataItem_stats_type\'>{lang="{$k}" pluralize="$v"}</span>

  {{if $k == \'forums_comments\'}}
      </a>
  {{endif}}


  {{if ( $k == \'forums_comments\' OR $k == \'answers_no_number\' ) && \IPS\forums\Topic::modPermission( \'unhide\', NULL, $row->container() ) AND $unapprovedComments = $row->mapped(\'unapproved_comments\')}}
   <a href=\'{$row->url()->setQueryString( \'queued_posts\', 1 )}\' class=\'ipsType_warning ipsType_small ipsPos_right ipsResponsive_noFloat\' data-ipsTooltip title=\'{lang="queued_posts_badge" pluralize="$row->topic_queuedposts"}\'><i class=\'fa fa-warning\'></i> <strong>{$unapprovedComments}</strong></a>
  {{endif}}
</li>',
    ),
  ),
), parent::hookData() );
}
/* End Hook Data */




























































































}