<?php

/**
 * ErrorHandler handles uncaught PHP errors and exceptions.
 *
 */

class Error
{
    /**
     * @var boolean whether to discard any existing page output before error display. Defaults to true.
     */
    public $discardExistingOutput = true;
    /**
     * @var integer the size of the reserved memory. A portion of memory is pre-allocated so that
     * when an out-of-memory issue occurs, the error handler is able to handle the error with
     * the help of this reserved memory. If you set this value to be 0, no memory will be reserved.
     * Defaults to 256KB.
     */
    public $memoryReserveSize = 262144;
    /**
     * @var \Exception the exception that is being handled currently.
     */
    public $exception;

    /**
     * @var string Used to reserve memory for fatal error handler.
     */
    private $_memoryReserve;


    /**
     * Register this error handler
     */
    public function register()
    {
        ini_set('display_errors', true);
        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
        if ($this->memoryReserveSize > 0) {
            $this->_memoryReserve = str_repeat('x', $this->memoryReserveSize);
        }
        register_shutdown_function([$this, 'handleFatalError']);
    }
    /**
     * Unregisters this error handler by restoring the PHP error and exception handlers.
     */
    public function unregister()
    {
        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * Handles uncaught PHP exceptions.
     *
     * This method is implemented as a PHP exception handler.
     *
     * @param \Exception $exception the exception that is not caught
     */
    public function handleException($exception)
    {
        if ($exception instanceof ExitException) {
            print_r($exception);
            return;
        }

        // disable error capturing to avoid recursive errors while handling exceptions
        $this->unregister();

        if ($exception instanceof PDOException) {
            $last_query = null;
            if(method_exists(Brightery::SuperInstance()->Database,'getLastQuery'))
                $last_query = Brightery::SuperInstance()->Database->getLastQuery();
            Brightery::loadFile([ROOT, 'styles', 'system', 'database_error.php'], false, ['exception'=> $exception, 'last_query' => $last_query]);
        }
        else
        {
//            print_r($exception);
            Brightery::loadFile([ROOT, 'styles', 'system', 'exceptions.php'], false, ['exception'=> $exception]);
        }

        $this->exception = $exception;
print_r($exception);


        exit(500);
//        try {
//            $this->logException($exception);
//            if ($this->discardExistingOutput) {
//                $this->clearOutput();
//            }
//            $this->renderException($exception);
//            if (!YII_ENV_TEST) {
//                exit(1);
//            }
//        } catch (\Exception $e) {
//            // an other exception could be thrown while displaying the exception
//            $msg = (string) $e;
//            $msg .= "\nPrevious exception:\n";
//            $msg .= (string) $exception;
//            if (YII_DEBUG) {
//                if (PHP_SAPI === 'cli') {
//                    echo $msg . "\n";
//                } else {
//                    echo '<pre>' . htmlspecialchars($msg, ENT_QUOTES, Yii::$app->charset) . '</pre>';
//                }
//            }
//            $msg .= "\n\$_SERVER = " . var_dump($_SERVER);
//            error_log($msg);
//            exit(1);
//        }

        $this->exception = null;
    }

    /**
     * Handles PHP execution errors such as warnings and notices.
     *
     * This method is used as a PHP error handler. It will simply raise an [[ErrorException]].
     *
     * @param integer $code the level of the error raised.
     * @param string $message the error message.
     * @param string $file the filename that the error was raised in.
     * @param integer $line the line number the error was raised at.
     * @return boolean whether the normal error handler continues.
     *
     * @throws ErrorException
     */
    public function handleError($code, $message, $file, $line)
    {
//        echo $code ."<br />";
//        echo $message ."<br />";
//        echo $file ."<br />";
//        echo $line ."<br />";
//        print_r(debug_backtrace());

//        if (error_reporting() & $code) {
//            // load ErrorException manually here because autoloading them will not work
//            // when error occurs while autoloading a class
////            if (!class_exists('yii\\base\\ErrorException', false)) {
//            require_once(__DIR__ . '/ErrorException.php');
////            }
//            $exception = new MyErrorException($message, $code, $code, $file, $line);
//
//            // in case error appeared in __toString method we can't throw any exception
//            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
//            array_shift($trace);
//            foreach ($trace as $frame) {
//                if ($frame['function'] == '__toString') {
//                    $this->handleException($exception);
//                    exit(1);
//                }
//            }
//
//            throw $exception;
//        }
//        return false;
    }

    /**
     * Handles fatal PHP errors
     */
    public function handleFatalError()
    {
        exit();
//        echo "df";
        unset($this->_memoryReserve);

        // load ErrorException manually here because autoloading them will not work
        // when error occurs while autoloading a class
//        if (!class_exists('yii\\base\\ErrorException', false)) {
//            require_once(__DIR__ . '/ErrorException.php');
//        }
//        print_r(error_get_last());
//        print_r(debug_backtrace());
        $error = error_get_last();

//        if (MyErrorException::isFatalError($error)) {
//            $exception = new MyErrorException($error['message'], $error['type'], $error['type'], $error['file'], $error['line']);
//            $this->exception = $exception;
//
//            $this->logException($exception);
//
//            if ($this->discardExistingOutput) {
//                $this->clearOutput();
//            }
//            $this->renderException($exception);
//
//            // need to explicitly flush logs because exit() next will terminate the app immediately
//            Yii::getLogger()->flush(true);
//
//            exit(1);
//        }
    }

    /**
     *    Check Syntax
     *    Performs a Syntax check within a php script, without killing the parser (hopefully)
     *    Do not use this with PHP 5 <= PHP 5.0.4, or rename this function.
     *
     *    @params    string    PHP to be evaluated
     *    @return    array    Parse error info or true for success
     **/
    function php_check_syntax( $php, $isFile=false )
    {
        # Get the string tokens
        $tokens = token_get_all( '<?php '.trim( $php  ));

        # Drop our manually entered opening tag
        array_shift( $tokens );
        $this->token_fix( $tokens );

        # Check to see how we need to proceed
        # prepare the string for parsing
        if( isset( $tokens[0][0] ) && $tokens[0][0] === T_OPEN_TAG )
            $evalStr = $php;
        else
            $evalStr = "<?php\n{$php}?>";

        if( $isFile OR ( $tf = tempnam( NULL, 'parse-' ) AND file_put_contents( $tf, $php ) !== FALSE ) AND $tf = $php )
        {
            # Prevent output
            ob_start();
            system( 'C:\inetpub\PHP\5.2.6\php -c "'.dirname(__FILE__).'/php.ini" -l < '.$php, $ret );
            $output = ob_get_clean();

            if( $ret !== 0 )
            {
                # Parse error to report?
                if( (bool)preg_match( '/Parse error:\s*syntax error,(.+?)\s+in\s+.+?\s*line\s+(\d+)/', $output, $match ) )
                {
                    return [
                        'line'    =>    (int)$match[2],
                        'msg'    =>    $match[1]
                    ];
                }
            }
            return true;
        }
        return false;
    }

//fixes related bugs: 29761, 34782 => token_get_all returns <?php NOT as T_OPEN_TAG
    function token_fix( &$tokens ) {
        if (!is_array($tokens) || (count($tokens)<2)) {
            return;
        }
        //return of no fixing needed
        if (is_array($tokens[0]) && (($tokens[0][0]==T_OPEN_TAG) || ($tokens[0][0]==T_OPEN_TAG_WITH_ECHO)) ) {
            return;
        }
        //continue
        $p1 = (is_array($tokens[0])?$tokens[0][1]:$tokens[0]);
        $p2 = (is_array($tokens[1])?$tokens[1][1]:$tokens[1]);
        $p3 = '';

        if (($p1.$p2 == '<?') || ($p1.$p2 == '<%')) {
            $type = ($p2=='?')?T_OPEN_TAG:T_OPEN_TAG_WITH_ECHO;
            $del = 2;
            //update token type for 3rd part?
            if (count($tokens)>2) {
                $p3 = is_array($tokens[2])?$tokens[2][1]:$tokens[2];
                $del = (($p3=='php') || ($p3=='='))?3:2;
                $type = ($p3=='=')?T_OPEN_TAG_WITH_ECHO:$type;
            }
            //rebuild erroneous token
            $temp = [$type, $p1.$p2.$p3];
            if (version_compare(phpversion(), '5.2.2', '<' )===false)
                $temp[] = isset($tokens[0][2])?$tokens[0][2]:'unknown';

            //rebuild
            $tokens[1] = '';
            if ($del==3) $tokens[2]='';
            $tokens[0] = $temp;
        }
        return;
    }

}


