//<?php

class hook280 extends _HOOK_CLASS_
{
	/**
	 * User post statistics
	 *
	 * @return	void
	 */
	public function userStats()
	{
		$id = (int) \IPS\Request::i()->id;

		/* Fetch our topic / forum container and make sure we have the proper permissions */
		try
		{
			$topic = \IPS\forums\Topic::load( $id );
			$forum = $topic->container();
			if ( $forum->can('view') and !$forum->loggedInMemberHasPasswordAccess() )
			{
				\IPS\Output::i()->redirect( $forum->url()->setQueryString( 'topic', $id ) );
			}

			if ( !$topic->canView() )
			{
				\IPS\Output::i()->error(  $forum ? $forum->errorMessage() : 'node_error_no_perm', '2F173/H', 403, '' );
			}
		}
		catch ( \OutOfRangeException $e )
		{
			\IPS\Output::i()->error( 'node_error', '2F173/1', 404, '' );
		}

		/* Fetch the post stats */
		$stats = \IPS\Db::i()->select(
			'core_members.*, forums_posts.post_date, count(forums_posts.pid) as total_posts',
			'forums_posts',
			array( "topic_id=?", $id ),
			'total_posts DESC',  // TODO: I'm not sure how to properly use sub-queries here for post_date sorting yet
			\IPS\Settings::i()->userTopicStats_maxResults ? \IPS\Settings::i()->userTopicStats_maxResults : null,
			'author_id'
		)->join(
			'core_members',
			'forums_posts.author_id=core_members.member_id'
		);

		/* Filter out the data we need and construct some objects for the template */
		$data = array();
		foreach ( $stats as $stat )
		{
			/* Is this a guest entry, and should we include guest stats? */
			if ( !$stat['member_id'] and !\IPS\Settings::i()->userTopicStats_includeGuests ) {
				continue;
			}

			$data[] = array(
				'member' => \IPS\Member::constructFromData( $stat ),
				'date'   => \IPS\DateTime::ts( $stat['post_date'] ),
				'total'  => $stat['total_posts']
			);
		}

		$title = \IPS\Member::loggedIn()->language()->addToStack( 'userTopicStats_title' ) . ' - ' . $topic->mapped('title') . ' - ' . $forum->_title;
		\IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( $title );
		\IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'plugins', 'core', 'global' )->topicUserStats( $data, $topic );
	}
}