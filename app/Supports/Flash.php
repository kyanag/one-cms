<?php


namespace App\Supports;


class Flash
{

    protected $messages = [];

    /**
     * Flash an information message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function info($message = null)
    {
        return $this->message($message, 'info');
    }

    /**
     * Flash a success message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function success($message = null)
    {
        return $this->message($message, 'success');
    }

    /**
     * Flash an error message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function error($message = null)
    {
        return $this->message($message, 'danger');
    }

    /**
     * Flash a warning message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function warning($message = null)
    {
        return $this->message($message, 'warning');
    }


    public function message($message, $level)
    {
        $message = compact("message", "level");
        $this->messages[] = $message;
        return $this;
    }


    public function getIterator(){
        foreach ($this->messages as $message){
            yield $message;
        }
    }
}