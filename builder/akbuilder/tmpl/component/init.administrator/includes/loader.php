<?php

function {COMPONENT_NAME}Loader($uri)
{
	return {COMPONENT_NAME_UCFIRST}Helper::_('loader.import', $uri) ;
}
