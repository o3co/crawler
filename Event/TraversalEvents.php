<?php
namespace O3Co\Crawler\Event;

class TraversalEvents 
{
	const onPreTraverse  = 'pre_traverse';
	const onTraverse     = 'on_traverse';
	const onPostTraverse = 'post_traverse';

	const onEnterTraverse = 'on_enter_traverse';
	const onLeaveTraverse = 'on_leave_traverse';

	const onPrePageVisit   = 'pre_page_visit';
	const onPostPageVisit  = 'post_page_visit';

	const onPrePageLeave   = 'pre_page_leave';
	const onPostPageLeave  = 'post_page_leave';


	const onException      = 'on_exception';
	const onResponse       = 'on_response';
}

