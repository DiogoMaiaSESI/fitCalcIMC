<?php

use Controller\ImcController;

use PHPUnit\Framework\TestCase;

class ImcTest extends TestCase {

    // IRÁ FAZER REFERENCIA A CLASSE IMCCONTROLLER
    // RESPONSÁVEL POR REALIZAR A COMUNIUCAÇÃO COM O BANCO DE DADOS
    // E A LÓGICA DA APLICAÇÃO
    private $imcController;

    protected function setUp(): void {
        $this->imcController = new ImcController();
    }



    // Verificar o cálculo do IMC
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_calculate_bmi() {
        $weight = 68;
        $height = 1.68;


        $imcResult = $this->imcController->calculateImc($weight, $height);

        $this->assertArrayHasKey('imc', $imcResult);
        $this->assertArrayHasKey('BMIrange', $imcResult);

        $this->assertEquals(24.09, $imcResult['imc']);
        $this->assertEquals('Peso normal', $imcResult['BMIrange']);
    }

    // Verificar a validação/retorno de campos inválidos
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_calculate_bmi_with_invalid_inputs () {
        $imcResult = $this->imcController->calculateImc(-68, 1.68);
        $this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);

        $imcResult = $this->imcController->calculateImc(68, -1.68);
        $this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);

        $imcResult = $this->imcController->calculateImc(-68, -1.68);
        $this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_calculate_bmi_with_null_or_empty_inputs () {
        $imcResult = $this->imcController->calculateImc(null, 0);
        $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIresult']);

        $imcResult = $this->imcController->calculateImc(0, null);
        $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIresult']);

        $imcResult = $this->imcController->calculateImc(null, null);
        $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIresult']);

        $imcResult = $this->imcController->calculateImc(0, 0);
        $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIresult']);
    }

    // OBTER O IMC E CLASSIFICAR
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_bmi_range() {
        $weight = 68;
        $height = 1.68;

        $imcResult = $this->imcController->calculateImc($weight, $height);

        $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
        $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);
    }

    // SALVAR O IMC
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_save_bmi() {}
}

?>