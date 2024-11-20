<?php 

class ContextManager
{
    // Set is used to save a new value under the context
    public static function set(string $key, mixed $value)
    {
        // Get the context object of the current coroutine
        $context = Co::getContext();

        // Long way of setting a new context value
        $context[$key] = $value;

        // Short method of setting a new context value, same as above code...
        Co::getContext()[$key] = $value;
    }

    // Navigate the coroutine tree and search for the requested key
    public static function get(string $key, mixed $default = null): mixed
    {
        // Get the current coroutine ID
        $cid = Co::getCid();

        do
        {
            /*
             * Get the context object using the current coroutine
             * ID and check if our key exists, looping through the
             * coroutine tree if we are deep inside sub coroutines.
             */
            $d = Co::getContext($cid)[$key];
            if(isset($d)) return $d;

            // We may be inside a child coroutine, let's check the parent ID for a context
            $cid = Co::getPcid($cid);

        } while ($cid !== -1 && $cid !== false);

        // The requested context variable and value could not be found
        return $default ?? throw new InvalidArgumentException(
            "Could not find `{$key}` in current coroutine context."
            );
    }
}
