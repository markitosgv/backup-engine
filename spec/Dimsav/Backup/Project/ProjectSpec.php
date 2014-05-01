<?php namespace spec\Dimsav\Backup\Project;

use Dimsav\Backup\Element\Element;
use Dimsav\Backup\Project\Project;
use Dimsav\Backup\Storage\Storage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Project
 */
class ProjectSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('Dimsav\Backup\Project\Project');
    }

    function it_receives_and_returns_storages($storages)
    {
        $this->setStorages($storages);
        $this->getStorages()->shouldReturn($storages);
    }

    function it_receives_and_returns_elements($elements)
    {
        $this->getElements()->shouldReturn(array());
        $this->setElements($elements);
        $this->getElements()->shouldReturn($elements);
    }

    function it_receives_and_returns_a_name($name)
    {
        $this->setName($name);
        $this->getName()->shouldReturn($name);
    }

    function it_throws_an_exception_if_the_temp_dir_is_invalid()
    {
        $exception = new \InvalidArgumentException("The temp directory '/fake/dir' is not valid. Make sure this path is writable.");
        $this->shouldThrow($exception)->duringBackup('/fake/dir');
    }

    function it_makes_the_backup(Element $element, Storage $storage)
    {
        $this->setName('my_project');
        $this->setStorages(array($storage));
        $this->setElements(array($element));

        $element->setExtractionDir(__DIR__)->shouldBeCalled();
        $element->extract()->shouldBeCalled();
        $element->getExtractedFiles()->shouldBeCalled()->willReturn(array('a', 'b'));

        $storage->store('a', 'my_project')->shouldBeCalled();
        $storage->store('b', 'my_project')->shouldBeCalled();
        $this->backup(__DIR__);
    }

}
