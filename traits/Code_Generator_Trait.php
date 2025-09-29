<?php

namespace traits\Code_Generator_Trait;

trait Code_Generator_Trait
{
    function code_generator()
    {
        $security_Code = random_int(111111, 999999);

        return $security_Code;
    }
}

