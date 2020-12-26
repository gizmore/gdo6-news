<?php
namespace GDO\News\Test;

use GDO\Tests\TestCase;
use GDO\News\Method\Write;
use GDO\Tests\MethodTest;
use function PHPUnit\Framework\assertEquals;
use GDO\News\GDO_News;
use function PHPUnit\Framework\assertStringContainsString;

/**
 * Tests for the news module.
 * @author gizmore
 * @version 6.10
 * @since 6.10
 */
final class NewsTest extends TestCase
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
        
        $getParameters = ['id' => '1'];
        $parameters['iso']['de']['newstext_message'] = '<div>Ich freue mich zu verkünden<br/><br/>Eine umfangreiche GDO6-Demo hat das Licht der Welt entdeckt.<br/><br/>Viel Spaß beim hacken!</div>';
        $response = MethodTest::make()->method($method)->getParameters($getParameters)->parameters($parameters)->execute();
        $html = $response->render();
        assertStringContainsString('freue mich zu verk', $html, 'Check if news message got changed.');
        assertEquals(1, GDO_News::table()->countWhere(), 'check if newscount still 1');
    }
    
}
