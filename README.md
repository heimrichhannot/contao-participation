# Participation

A contao backend entity, that allows you to participate to another entity (like news, events) from any url.

## Features

- Participation Archive (global config for participation entitites within)
- Participation (alias to entity connection table)
- Participation Data (member/submission to participation connection table)
  
## How to extend/invoke with your module

You can invoke into participation and participation data. Both should be done within your config.php.
Here an example for news with tl_member as participation data:

config.php

```
$GLOBALS['TL_PARTICIPATION']['news'] = array
(
	'tl_news' => 'NewsParticipationConfig'
);


$GLOBALS['TL_PARTICIPATION_DATA'] = array
(
	'member' => array
	(
		'tl_member'   => 'ParticipationDataMyMemberConfig',
	)
);
```

The Class have to extend from \HeimrichHannot\Participation\ParticipationConfig

NewsParticipationConfig.php

```
class NewsParticipationConfig extends \HeimrichHannot\Participation\ParticipationConfig
{
	protected $strSourceField = 'headline';

	protected $strParentField = 'title';
}
```

ParticipationDataMyMemberConfig.php
 
```
class ParticipationDataMyMemberConfig extends ParticipationDataMemberConfig
{
	protected function getSourceOptionValue(\Model $objSource)
	{
		return $objSource->firstname . ' ' . $objSource->lastname . ' [ID: ' . $objSource->id . ']';
	}
}

```

