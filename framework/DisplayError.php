<?php

namespace Illuminate\framework;

class DisplayError
{
  public $errors = [];
  public $var;

  public function customErrorHandler(int $errno, string $errstr, string $errfile = null, int $errline = null)
  {
    $log = "[" . date('Y-m-d H:i:s') . "] Error: $errstr in $errfile on line $errline";
    $hr = '______';
    file_put_contents('error.log', $hr . PHP_EOL, FILE_APPEND);
    file_put_contents('error.log', $log . PHP_EOL, FILE_APPEND);

    $error = [
      'type' => $errno,
      'message' => $errstr,
      'file' => $errfile,
      'line' => $errline
    ];

    $this->errors[] = $error;

    if (count($this->errors) > 0) {
      http_response_code(500);
      json_encode(['success' => false, 'data' => ['errors' => $this->errors]]);
      $this->displayErrorPage();
    }
  }

  public function displayErrorPage()
  {
    ob_clean();

    if (count($this->errors) > 0) {
      
      foreach ($this->errors as $error) {
        $type = $error['type'];
        $message = $error['message'];
        $file = $error['file'];
        $line = $error['line'];
        echo "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                *{
                  font-family: Arial, Helvetica, sans-serif;
                  box-sizing: border-box;
                }

                p {
                    font-size: 16px;
                    margin-bottom: 5px;
                    color:#000;
                }

                .container-error {
                    width: 100%;
                    height: auto;
                    padding: 10px 30px;
                    background-color: rgba(255, 148, 148, 0.2);
                    border-radius: 10px;
                }

                .align-items-center {
                align-items: center
                }

                .fw-bold {
                font-weight: 700;
                }

                .container-fluid{
                  width:100%;
                }

                .gap-2 {
                gap: 10px;
                }
                
                .text-danger{
                  color: red;
                }

                .d-flex{
                  display:flex;
                }

                .mt-2{
                  margin-top:10px;
                }
                </style>
            </head>
            <body>
                <div class=\"container-fluid mt-2\">
                <div class=\"container-error\">
                    <div class=\"d-flex align-items-center gap-2\">
                        <p class=\"text-danger fw-bold\">An error:</p>
                        <p>$message</p>
                    </div>
                    <div class=\"d-flex align-items-center gap-2\">
                        <p><span class=\"fw-bold\">$type:</span> $file</p>
                        <p><span class=\"fw-bold text-danger\">on</span> $line</p>
                    </div>
                </div>
                </div>
            </body>
            </html>
            ";
      }
    }
  }

  public function setErrorHandler()
  {
    $errorHandler = [$this, 'customErrorHandler'];

    set_error_handler($errorHandler);
  }
}
