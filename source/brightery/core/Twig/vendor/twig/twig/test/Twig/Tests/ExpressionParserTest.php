<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please views the LICENSE
 * file that was distributed with this source code.
 */

class Twig_Tests_ExpressionParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Twig_Error_Syntax
     * @dataProvider getFailingTestsForAssignment
     */
    public function testCanOnlyAssignToNames($template)
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize($template, 'index'));
    }

    public function getFailingTestsForAssignment()
    {
        return [
            ['{% set false = "foo" %}'],
            ['{% set true = "foo" %}'],
            ['{% set none = "foo" %}'],
            ['{% set 3 = "foo" %}'],
            ['{% set 1 + 2 = "foo" %}'],
            ['{% set "bar" = "foo" %}'],
            ['{% set %}{% endset %}'],
        ];
    }

    /**
     * @dataProvider getTestsForArray
     */
    public function testArrayExpression($template, $expected)
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $stream = $env->tokenize($template, 'index');
        $parser = new Twig_Parser($env);

        $this->assertEquals($expected, $parser->parse($stream)->getNode('body')->getNode(0)->getNode('expr'));
    }

    /**
     * @expectedException Twig_Error_Syntax
     * @dataProvider getFailingTestsForArray
     */
    public function testArraySyntaxError($template)
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize($template, 'index'));
    }

    public function getFailingTestsForArray()
    {
        return [
            ['{{ [1, "a": "b"] }}'],
            ['{{ {"a": "b", 2} }}'],
        ];
    }

    public function getTestsForArray()
    {
        return [
            // simple array
            ['{{ [1, 2] }}', new Twig_Node_Expression_Array([
                  new Twig_Node_Expression_Constant(0, 1),
                  new Twig_Node_Expression_Constant(1, 1),

                  new Twig_Node_Expression_Constant(1, 1),
                  new Twig_Node_Expression_Constant(2, 1),
            ], 1),
            ],

            // array with trailing ,
            ['{{ [1, 2, ] }}', new Twig_Node_Expression_Array([
                  new Twig_Node_Expression_Constant(0, 1),
                  new Twig_Node_Expression_Constant(1, 1),

                  new Twig_Node_Expression_Constant(1, 1),
                  new Twig_Node_Expression_Constant(2, 1),
            ], 1),
            ],

            // simple hash
            ['{{ {"a": "b", "b": "c"} }}', new Twig_Node_Expression_Array([
                  new Twig_Node_Expression_Constant('a', 1),
                  new Twig_Node_Expression_Constant('b', 1),

                  new Twig_Node_Expression_Constant('b', 1),
                  new Twig_Node_Expression_Constant('c', 1),
            ], 1),
            ],

            // hash with trailing ,
            ['{{ {"a": "b", "b": "c", } }}', new Twig_Node_Expression_Array([
                  new Twig_Node_Expression_Constant('a', 1),
                  new Twig_Node_Expression_Constant('b', 1),

                  new Twig_Node_Expression_Constant('b', 1),
                  new Twig_Node_Expression_Constant('c', 1),
            ], 1),
            ],

            // hash in an array
            ['{{ [1, {"a": "b", "b": "c"}] }}', new Twig_Node_Expression_Array([
                  new Twig_Node_Expression_Constant(0, 1),
                  new Twig_Node_Expression_Constant(1, 1),

                  new Twig_Node_Expression_Constant(1, 1),
                  new Twig_Node_Expression_Array([
                        new Twig_Node_Expression_Constant('a', 1),
                        new Twig_Node_Expression_Constant('b', 1),

                        new Twig_Node_Expression_Constant('b', 1),
                        new Twig_Node_Expression_Constant('c', 1),
                  ], 1),
            ], 1),
            ],

            // array in a hash
            ['{{ {"a": [1, 2], "b": "c"} }}', new Twig_Node_Expression_Array([
                  new Twig_Node_Expression_Constant('a', 1),
                  new Twig_Node_Expression_Array([
                        new Twig_Node_Expression_Constant(0, 1),
                        new Twig_Node_Expression_Constant(1, 1),

                        new Twig_Node_Expression_Constant(1, 1),
                        new Twig_Node_Expression_Constant(2, 1),
                  ], 1),
                  new Twig_Node_Expression_Constant('b', 1),
                  new Twig_Node_Expression_Constant('c', 1),
            ], 1),
            ],
        ];
    }

    /**
     * @expectedException Twig_Error_Syntax
     */
    public function testStringExpressionDoesNotConcatenateTwoConsecutiveStrings()
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false, 'optimizations' => 0]);
        $stream = $env->tokenize('{{ "a" "b" }}', 'index');
        $parser = new Twig_Parser($env);

        $parser->parse($stream);
    }

    /**
     * @dataProvider getTestsForString
     */
    public function testStringExpression($template, $expected)
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false, 'optimizations' => 0]);
        $stream = $env->tokenize($template, 'index');
        $parser = new Twig_Parser($env);

        $this->assertEquals($expected, $parser->parse($stream)->getNode('body')->getNode(0)->getNode('expr'));
    }

    public function getTestsForString()
    {
        return [
            [
                '{{ "foo" }}', new Twig_Node_Expression_Constant('foo', 1),
            ],
            [
                '{{ "foo #{bar}" }}', new Twig_Node_Expression_Binary_Concat(
                    new Twig_Node_Expression_Constant('foo ', 1),
                    new Twig_Node_Expression_Name('bar', 1),
                    1
                ),
            ],
            [
                '{{ "foo #{bar} baz" }}', new Twig_Node_Expression_Binary_Concat(
                    new Twig_Node_Expression_Binary_Concat(
                        new Twig_Node_Expression_Constant('foo ', 1),
                        new Twig_Node_Expression_Name('bar', 1),
                        1
                    ),
                    new Twig_Node_Expression_Constant(' baz', 1),
                    1
                ),
            ],

            [
                '{{ "foo #{"foo #{bar} baz"} baz" }}', new Twig_Node_Expression_Binary_Concat(
                    new Twig_Node_Expression_Binary_Concat(
                        new Twig_Node_Expression_Constant('foo ', 1),
                        new Twig_Node_Expression_Binary_Concat(
                            new Twig_Node_Expression_Binary_Concat(
                                new Twig_Node_Expression_Constant('foo ', 1),
                                new Twig_Node_Expression_Name('bar', 1),
                                1
                            ),
                            new Twig_Node_Expression_Constant(' baz', 1),
                            1
                        ),
                        1
                    ),
                    new Twig_Node_Expression_Constant(' baz', 1),
                    1
                ),
            ],
        ];
    }

    /**
     * @expectedException Twig_Error_Syntax
     */
    public function testAttributeCallDoesNotSupportNamedArguments()
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize('{{ foo.bar(name="Foo") }}', 'index'));
    }

    /**
     * @expectedException Twig_Error_Syntax
     */
    public function testMacroCallDoesNotSupportNamedArguments()
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize('{% from _self import foo %}{% macro foo() %}{% endmacro %}{{ foo(name="Foo") }}', 'index'));
    }

    /**
     * @expectedException        Twig_Error_Syntax
     * @expectedExceptionMessage An argument must be a name. Unexpected token "string" of value "a" ("name" expected) in "index" at line 1
     */
    public function testMacroDefinitionDoesNotSupportNonNameVariableName()
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize('{% macro foo("a") %}{% endmacro %}', 'index'));
    }

    /**
     * @expectedException        Twig_Error_Syntax
     * @expectedExceptionMessage A default value for an argument must be a constant (a boolean, a string, a number, or an array) in "index" at line 1
     * @dataProvider             getMacroDefinitionDoesNotSupportNonConstantDefaultValues
     */
    public function testMacroDefinitionDoesNotSupportNonConstantDefaultValues($template)
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize($template, 'index'));
    }

    public function getMacroDefinitionDoesNotSupportNonConstantDefaultValues()
    {
        return [
            ['{% macro foo(name = "a #{foo} a") %}{% endmacro %}'],
            ['{% macro foo(name = [["b", "a #{foo} a"]]) %}{% endmacro %}'],
        ];
    }

    /**
     * @dataProvider getMacroDefinitionSupportsConstantDefaultValues
     */
    public function testMacroDefinitionSupportsConstantDefaultValues($template)
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize($template, 'index'));
    }

    public function getMacroDefinitionSupportsConstantDefaultValues()
    {
        return [
            ['{% macro foo(name = "aa") %}{% endmacro %}'],
            ['{% macro foo(name = 12) %}{% endmacro %}'],
            ['{% macro foo(name = true) %}{% endmacro %}'],
            ['{% macro foo(name = ["a"]) %}{% endmacro %}'],
            ['{% macro foo(name = [["a"]]) %}{% endmacro %}'],
            ['{% macro foo(name = {a: "a"}) %}{% endmacro %}'],
            ['{% macro foo(name = {a: {b: "a"}}) %}{% endmacro %}'],
        ];
    }

    /**
     * @expectedException        Twig_Error_Syntax
     * @expectedExceptionMessage The function "cycl" does not exist. Did you mean "cycle" in "index" at line 1
     */
    public function testUnknownFunction()
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize('{{ cycl() }}', 'index'));
    }

    /**
     * @expectedException        Twig_Error_Syntax
     * @expectedExceptionMessage The filter "lowe" does not exist. Did you mean "lower" in "index" at line 1
     */
    public function testUnknownFilter()
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize('{{ 1|lowe }}', 'index'));
    }

    /**
     * @expectedException        Twig_Error_Syntax
     * @expectedExceptionMessage The test "nul" does not exist. Did you mean "null" in "index" at line 1
     */
    public function testUnknownTest()
    {
        $env = new Twig_Environment(new Twig_Loader_String(), ['cache' => false, 'autoescape' => false]);
        $parser = new Twig_Parser($env);

        $parser->parse($env->tokenize('{{ 1 is nul }}', 'index'));
    }
}
