<?php
    include('../script/details.php');
    
    $options_hash  = [];

    function InitOptionsHash() {
        global $options_hash;
        
        $options_hash['language']                   = 'en';
        $options_hash['allow-coach']                = 'OFF';
        $options_hash['check-access']               = 'OFF';
        $options_hash['check-bus-stop']             = 'OFF';
        $options_hash['check-motorway-link']        = 'OFF';
        $options_hash['check-name']                 = 'OFF';
        $options_hash['check-name-relaxed']         = 'OFF';
        $options_hash['check-osm-separator']        = 'OFF';
        $options_hash['check-platform']             = 'OFF';
        $options_hash['check-roundabouts']          = 'OFF';
        $options_hash['check-route-ref']            = 'OFF';
        $options_hash['check-sequence']             = 'OFF';
        $options_hash['check-stop-position']        = 'OFF';
        $options_hash['check-version']              = 'OFF';
        $options_hash['coloured-sketchline']        = 'OFF';
        $options_hash['expect-network-long']        = 'OFF';
        $options_hash['expect-network-long-as']     = '';
        $options_hash['expect-network-long-for']    = '';
        $options_hash['expect-network-short']       = 'OFF';
        $options_hash['expect-network-short-as']    = '';
        $options_hash['expect-network-short-for']   = '';
        $options_hash['max-error']                  = '';
        $options_hash['multiple-ref-type-entries']  = 'analyze';
        $options_hash['network-long-regex']         = '';
        $options_hash['network-short-regex']        = '';
        $options_hash['operator-regex']             = '';
        $options_hash['positive-notes']             = 'OFF';
        $options_hash['ptv1-compatibility']         = 'no';
        $options_hash['relaxed-begin-end-for']      = '';
        $options_hash['strict-network']             = 'OFF';
        $options_hash['strict-operator']            = 'OFF';
        $options_hash['separator']                  = '\;';
        $options_hash['or-separator']               = '\|';
        $options_hash['ref-separator']              = '\/';
    }
    
    function ReadOptionDetails() {
        global $details_hash;
        global $options_hash;
        
        InitOptionsHash();
        
        foreach ( $options_hash as $option => $value ) {
            if ( isset($details_hash[$option]) ) {
                $options_hash[$option] = $details_hash[$option];
            }
        }
        
        if ( isset($details_hash['analysis-options']) ) {
            $split_options = preg_split( '/--/', $details_hash['analysis-options'] );
            
            foreach ( $split_options as $complete_option ) {
                $complete_option = rtrim(ltrim($complete_option));
                $option_parts = explode( '=', $complete_option, 2 );
                $option = rtrim(ltrim(array_shift($option_parts)));
                if ( $option ) {
                    if ( count($option_parts) > 0 ) {
                        $options_hash[$option] = rtrim(ltrim($option_parts[0]));
                    } else {
                        $options_hash[$option] = 'ON';
                    }
                }
            }
        }
        
    }
    
    function GetOverpassQuery() {
        global $details_hash;
        if ( isset($details_hash['OVERPASS_QUERY']) ) {
            $link = explode( '=', $details_hash['OVERPASS_QUERY'], 2 );
            if ( count($link) > 1 ) {
                return( $link[0] . '=' . urldecode($link[1]) );
            } else {
                return( $details_hash['OVERPASS_QUERY'] );
            }
        }
        return( '' );
    }
    
    function GetRegionLink() {
        global $details_hash;
        if ( isset($details_hash['REGION_LINK']) ) {
            $link = explode( '=', $details_hash['REGION_LINK'], 2 );
            if ( count($link) > 1 ) {
                return( $link[0] . '=' . urlencode(urldecode($link[1])) );
            } else {
                return( $details_hash['REGION_LINK'] );
            }
        }
        return( '' );
    }
    
    function GetOsmXmlFileSize() {
        global $details_hash;
        return( $details_hash['OSM_XML_FILE_SIZE'] / 1024 );
    }
    
    function GetOsmXmlFileDate() {
        global $details_hash;
    }
    
    function GetStartDownloadDate() {
        global $details_hash;
    }
    
    function GetEndDownloadDate() {
        global $details_hash;
    }
    
    function GetStartAnalysisDate() {
        global $details_hash;
    }
    
    function GetEndAnalysisDate() {
        global $details_hash;
    }
    
    function PrintOptionDetails( $lang ) {
        global $options_hash;
        
        ReadOptionDetails();
        
        if ( !isset($lang) ) { $lang = 'en'; }
        
        foreach ( $options_hash as $option => $value ) {
            printf( "<tr class=\"message-tablerow\"><td class=\"message-text\">" );
            $value = htmlentities($value);
            printf( "<a href=\"/%s/index.php#option-%s\">%s</a></td>", $lang, $option, $option );
            printf( "<td class=\"message-option\">%s</td></tr>\n", $value );
        }
    }
    

        



?>

