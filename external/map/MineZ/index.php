<?php 
/**
 * For any 404 request, we carry the request over to Minez's Dynamic Map
 * and then we cache the result.  This allows us to have a decent map and
 * to cache the data - so that we can stop crashing the MineZ website when
 * we want to look at a dynamic map.
 */

