<?php

namespace App\Tests\Functional;

use PHPUnit\Framework\TestCase;

class FunctionalTest extends TestCase
{
    /**
     *
     * В функциональных тестах мы обычно загружаем все приложение и вызываем определенный маршрут.
     * Здесь для простоты вы можете использовать встроенную функцию PHP file_get_contents () с URL-адресом приложения в
     * качестве аргумента. Сделайте здесь два утверждения:
     *
     * 1. Ответ содержит: 'This is an awesome App!' - пройдет
     * 2. Ответ соответствует следующему шаблону регулярного выражения:
     * /Good (morning|afternoon|evening|nigth) [A-Z]{1}[a-z]+/ - завершится ошибкой,
     * потому что первая буква имени пользователя (из db) не является верхним
     * регистром, и эта часть регулярного выражения [AZ]{1} отвечает за проверку этого
     *
     * Второй неудачный тест скажет вам, что случилось. Но это будет не так отчетливо видно, как в интеграционном
     * тесте, который вы напишете позже.
     */
    public function testCanSeeCorrectSentence(): void
    {
        $source = file_get_contents('http://php-unit-course.loc');

        self::assertStringContainsString('This is an awesome App!', $source);
        self::assertRegExp('/Good (morning|afternoon|evening|nigth) [A-Z]{1}[a-z]+/', $source);

    }
}