<?php

namespace Forge\Subdomain;

use Forge\Foundation;
use Forge\Subdomain\Valid;
use Forge\Subdomain\Request;
use Forge\Route as Forge_Route;

class Route extends Forge_Route
{
    const SUBDOMAIN_WILDCARD = '*';
    const SUBDOMAIN_EMPTY    = '' ;

    public static $default_subdomains = array(
        self::SUBDOMAIN_EMPTY,
        'www',
    );

    protected $_subdomain;

    public function __construct( $uri = NULL, $regex = NULL )
    {
        parent::__construct( $uri, $regex );

        // Set default subdomains in this route rule
        $this->_subdomain = self::$default_subdomains;
    }

    /**
     * Set one or more subdomains to execute this route
     *
     * @param  array    name(s) of subdomain(s) to apply in route
     * @return Route
     */
    public function subdomains( array $name )
    {
        $this->_subdomain = $name;

        return $this;
    }

    public function matches( Request $request, $subdomain = NULL )
    {
        $subdomain = ( ! isset( $subdomain ) || $subdomain === NULL ) ? Request::$subdomain : $subdomain;

        if( $subdomain === FALSE )
        {
            $subdomain = self::SUBDOMAIN_EMPTY;
        }

        if( in_array( self::SUBDOMAIN_WILDCARD, $this->_subdomain ) || in_array( $subdomain, $this->_subdomain ) )
        {
            return parent::matches( $request );
        }

        return FALSE;
    }
    
}
