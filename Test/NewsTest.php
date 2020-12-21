<?php
namespace GDO\News\Test;

use GDO\Tests\TestCase;
use GDO\News\Method\Write;
use GDO\Tests\MethodTest;
use function PHPUnit\Framework\assertEquals;
use GDO\News\GDO_News;
use function PHPUnit\Framework\assertStringContainsString;

final class testNews extends TestCase
{
    public function testNews()
    {
        $method = Write::make();
        $parameters = [
            'iso' => [
                'en' => [
                    'newstext_title' => 'Test news entry',
                    'newstext_message' => '<div>I am happy to announce.<br/><br/>A comprehensive demo is available.<br/><br/>Happy Challenging!</div>',
                ],
                'de' => [
                    'newstext_title' => 'Test News Eintrag',
                    'newstext_message' => '<div>Ich freue zu verkünden<br/><br/>Eine umfangreiche GDO6-Demo hat das Licht der Welt entdeckt.<br/><br/>Viel Spaß beim hacken!</div>',
                ],
            ],
        ];
        $response = MethodTest::make()->method($method)->parameters($parameters)->execute();
        $this->assert200("Check if a News::Write entry can be created.");
        assertEquals(1, GDO_News::table()->countWhere(), 'check if news were created.');
        
        $parameters['iso']['de']['newstext_message'] = '<div>Ich freue zu verkünden<br/><br/>Eine umfangreiche GDO6-Demo hat das Licht der Welt entdeckt.<br/><br/>Viel Spaß beim hacken!</div>';
        $response = MethodTest::make()->method($method)->parameters($parameters)->execute();
        assertStringContainsString('freue zu verk', $response->renderCell(), 'Check if news message got changed.');
        assertEquals(1, GDO_News::table()->countWhere(), 'check if newscount still 1');
        
    }
    
}
