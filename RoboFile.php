<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    // define public methods as commands
    use \Codeception\Task\MergeReports;
    use \Codeception\Task\SplitTestsByGroups;

    public function parallelSplitTests()
    {
        $this->taskSplitTestFilesByGroups(5)
            ->projectRoot('.')
            ->testsFrom('tests/acceptance')
            ->groupsTo('tests/_data/paracept_')
            ->run();
    }

	public function parallelRun()
	{
		$parallel = $this->taskParallelExec();
		for ($i = 1; $i <= 5; $i++) {
			$parallel->process(
				$this->taskCodecept() // use built-in Codecept task
				->suite('acceptance') // run acceptance tests
				->group("paracept_$i") // for all paracept_* groups
				->xml("result_paracept_$i.xml") // save XML results
			);
		}
		return $parallel->run();
	}


    public function parallelMergeResults()
    {
        $merge = $this->taskMergeXmlReports();
        for ($i=1; $i<=5; $i++) {
            $merge->from("tests/_output/result_paracept_$i.xml");
        }
        $merge->into("tests/_output/result_paracept.xml")->run();
    }

    function parallelAll()
    {
        $this->parallelSplitTests();
        $result = $this->parallelRun();
        $this->parallelMergeResults();
        return $result;
    }
}