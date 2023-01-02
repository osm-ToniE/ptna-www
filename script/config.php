<?php
    include('../script/parse_query.php');
    include('../script/details.php');

    $options_hash  = [];

    function InitOptionsHash() {
        global $options_hash;

        $options_hash['language']                   = 'en';
        $options_hash['allow-coach']                = 'OFF';
        $options_hash['check-access']               = 'OFF';
        $options_hash['check-bus-stop']             = 'OFF';
        $options_hash['check-gtfs']                 = 'OFF';
        $options_hash['check-motorway-link']        = 'OFF';
        $options_hash['check-name']                 = 'OFF';
        $options_hash['check-name-relaxed']         = 'OFF';
        $options_hash['check-osm-separator']        = 'OFF';
        $options_hash['check-platform']             = 'OFF';
        $options_hash['check-roundabouts']          = 'OFF';
        $options_hash['check-route-ref']            = 'OFF';
        $options_hash['check-sequence']             = 'OFF';
        $options_hash['check-service-type']         = 'OFF';
        $options_hash['check-stop-position']        = 'OFF';
        $options_hash['check-version']              = 'OFF';
        $options_hash['check-way-type']             = 'OFF';
        $options_hash['coloured-sketchline']        = 'OFF';
        $options_hash['expect-network-long']        = 'OFF';
        $options_hash['expect-network-long-as']     = '';
        $options_hash['expect-network-long-for']    = '';
        $options_hash['expect-network-short']       = 'OFF';
        $options_hash['expect-network-short-as']    = '';
        $options_hash['expect-network-short-for']   = '';
        $options_hash['gtfs-feed']                  = '';
        $options_hash['link-gtfs']                  = 'OFF';
        $options_hash['max-error']                  = '';
        $options_hash['multiple-ref-type-entries']  = 'analyze';
        $options_hash['network-long-regex']         = '';
        $options_hash['network-short-regex']        = '';
        $options_hash['no-additional-navigation']   = 'OFF';
        $options_hash['operator-regex']             = '';
        $options_hash['positive-notes']             = 'OFF';
        $options_hash['ptv1-compatibility']         = 'no';
        $options_hash['relaxed-begin-end-for']      = '';
        $options_hash['show-gtfs']                  = 'OFF';
        $options_hash['strict-network']             = 'OFF';
        $options_hash['strict-operator']            = 'OFF';
        $options_hash['separator']                  = ';';
        $options_hash['or-separator']               = '|';
        $options_hash['ref-separator']              = '/';
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

            return 1;
        }

        return 0;

    }

    function GetAllNetworks() {
        global $path_to_work;
        $networks = [];
        $files  = glob( $path_to_work."*/*-details.txt" );
        foreach ( $files as $file ) {
            $filename = basename( $file );
            $filename = str_replace( "-Analysis-details.txt", "", $filename );
            array_push( $networks, $filename );
        }
        $files = glob( $path_to_work."*/*/*-details.txt" );
        foreach ( $files as $file ) {
            $filename = basename( $file );
            $filename = str_replace( "-Analysis-details.txt", "", $filename );
            array_push( $networks, $filename );
        }
        sort( $networks );
        return( $networks );
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

    function GetRegionName() {
        global $details_hash;
        if ( isset($details_hash['REGION_NAME']) ) {
            return( $details_hash['REGION_NAME'] );
        }
        return( '' );
    }

    function GetOsmXmlFileName() {
        global $details_hash;
        if ( isset($details_hash['OSM_XML_FILE']) ) {
            return( $details_hash['OSM_XML_FILE'] );
        }
        return( '' );
    }

    function GetOsmXmlFileSize() {
        global $details_hash;
        if ( isset($details_hash['OSM_XML_FILE_SIZE']) ) {
            return( $details_hash['OSM_XML_FILE_SIZE'] / 1024 );
        }
        return( 0 );
    }

    function GetOsmXmlFileSizeMB() {
        global $details_hash;
        if ( isset($details_hash['OSM_XML_FILE_SIZE_BYTE']) ) {
            return( $details_hash['OSM_XML_FILE_SIZE_BYTE'] / 1024 / 1024 );
        } else {
            if ( isset($details_hash['OSM_XML_FILE_SIZE']) ) {
                return( $details_hash['OSM_XML_FILE_SIZE'] / 1024 );
            }
        }
        return( 0 );
    }

    function GetOsmXmlFileSizeByte() {
        global $details_hash;
        if ( isset($details_hash['OSM_XML_FILE_SIZE_BYTE']) ) {
            return( $details_hash['OSM_XML_FILE_SIZE_BYTE'] );
        } else {
            if ( isset($details_hash['OSM_XML_FILE_SIZE']) ) {
                return( $details_hash['OSM_XML_FILE_SIZE'] * 1024 );
            }
        }
        return( 0 );
    }

    function GetOsmXmlFileDate() {
        global $details_hash;
        if ( isset($details_hash['OSM_XML_FILE_DATE']) ) {
            return( $details_hash['OSM_XML_FILE_DATE'] );
        }
        return( '' );
    }

    function GetStartDownloadDate() {
        global $details_hash;
        if ( isset($details_hash['START_DOWNLOAD']) ) {
            return( $details_hash['START_DOWNLOAD'] );
        }
        return( '' );
    }

    function GetEndDownloadDate() {
        global $details_hash;
        if ( isset($details_hash['END_DOWNLOAD']) ) {
            return( $details_hash['END_DOWNLOAD'] );
        }
        return( '' );
    }

    function GetOsmBase() {
        global $details_hash;
        if ( isset($details_hash['OSM_BASE']) ) {
            return( $details_hash['OSM_BASE'] );
        }
        return( '' );
    }

    function GetRoutesLink() {
        global $details_hash;
        if ( isset($details_hash['ROUTES_LINK']) ) {
            $link = explode( '=', $details_hash['ROUTES_LINK'], 2 );
            if ( count($link) > 1 ) {
                return( $link[0] . '=' . urlencode(urldecode($link[1])) );
            } else {
                return( $details_hash['ROUTES_LINK'] );
            }
        }
        return( '' );
    }

    function GetRoutesSize() {
        global $details_hash;
        if ( isset($details_hash['ROUTES_SIZE']) ) {
            return( $details_hash['ROUTES_SIZE'] );
        }
        return( 0 );
    }

    function GetRoutesDate() {
        global $details_hash;
        if ( isset($details_hash['ROUTES_TIMESTAMP_LOC']) ) {
            return( $details_hash['ROUTES_TIMESTAMP_LOC'] );
        }
        return( '' );
    }

    function GetHtmlFileWebPath() {
        global $filename_hash;
        if ( isset($filename_hash['ANALYSISWEBPATH']) ) {
            return( $filename_hash['ANALYSISWEBPATH'] );
        }
        return( '' );
    }

    function GetStartAnalysisDate() {
        global $details_hash;
        if ( isset($details_hash['START_ANALYSIS']) ) {
            return( $details_hash['START_ANALYSIS'] );
        }
        return( '' );
    }

    function GetEndAnalysisDate() {
        global $details_hash;
        if ( isset($details_hash['END_ANALYSIS']) ) {
            return( $details_hash['END_ANALYSIS'] );
        }
        return( '' );
    }

    function HasChanges() {
        global $details_hash;
        if ( isset($details_hash['OLD_OR_NEW']) && $details_hash['OLD_OR_NEW'] == 'new' ) {
            return( 1 );
        }
        return( 0 );
    }

    function GetHtmlDiff() {
        global $details_hash;
        if ( isset($details_hash['HTML_DIFF']) ) {
            return( $details_hash['HTML_DIFF'] );
        }
        return( 0 );
    }

    function GetDiffFileWebPath() {
        global $filename_hash;
        if ( isset($filename_hash['DIFFWEBPATH']) ) {
            return( $filename_hash['DIFFWEBPATH'] );
        }
        return( '' );
    }

    function GetDiscussionPagePtna( ) {
        return( "https://wiki.openstreetmap.org/wiki/User_talk:ToniE/ptna" );
    }

    function GetDiscussionPageNetwork( ) {
        global $details_hash;
        if ( isset($details_hash['DISCUSSION_LINK']) ) {
            return( $details_hash['DISCUSSION_LINK'] );
        } else {
            return ( '' );
        }
    }

    function GetDetailsTZNAME() {
        global $details_hash;
        if ( isset($details_hash['TZNAME']) ) {
            return( $details_hash['TZNAME'] );
        } elseif ( isset($details_hash['TZ']) ) {
            return( $details_hash['TZ'] );
        }
        return( '' );
    }

    function GetDetailsTZSHORT() {
        global $details_hash;
        if ( isset($details_hash['TZSHORT']) ) {
            $details_hash['TZSHORT'] = str_replace( "-", "UTC-", $details_hash['TZSHORT'] );
            $details_hash['TZSHORT'] = str_replace( "+", "UTC+", $details_hash['TZSHORT'] );
            return( $details_hash['TZSHORT'] );
        }
        return( '' );
    }

    function GetDetailsUTC() {
        global $details_hash;
        if ( isset($details_hash['UTC']) ) {
            return( $details_hash['UTC'] );
        }
        return( '' );
    }

    function PrintOptionDetails( $lang ) {
        global $options_hash;

        if ( ReadOptionDetails() ) {

            if ( !isset($lang) ) { $lang = 'en'; }

            foreach ( $options_hash as $option => $value ) {
                printf( "<tr class=\"message-tablerow\"><td class=\"message-text\">" );
                $value = htmlentities($value);
                printf( "<a href=\"/%s/index.php#option-%s\">%s</a></td>", $lang, $option, $option );
                printf( "<td class=\"message-option\">%s</td></tr>\n", $value );
            }
        }
    }

?>
