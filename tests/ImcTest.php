<?php

use Controller\ImcController;

use PHPUnit\Framework\TestCase;

use Model\Imcs;

class ImcTest extends TestCase {

    // IRÁ FAZER REFERENCIA A CLASSE IMCCONTROLLER
    // RESPONSÁVEL POR REALIZAR A COMUNIUCAÇÃO COM O BANCO DE DADOS
    // E A LÓGICA DA APLICAÇÃO
    private $imcController;
    // ATRIBUTO PARA O FAKE DO BANCO DE DADOS
    private $mockImcModel;

    protected function setUp(): void {
        // CRIO O FAKE DO BANCO DE DADOS
        $this->mockImcModel = $this->createMock(Imcs::class);
        // PASSO ESSE FAKE PARA O CONTROLLER, ASSIM ME PERMITE UTILIZAR AS MESMAS FUNCIONALIDADES, SÓ QUE SEM MODIFICAR O BANCO DE DADOS REAL
        $this->imcController = new ImcController($this->mockImcModel);
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

        $imcResult = $this->imcController->calculateImc(0, 0);
        $this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_be_able_to_calculate_bmi_with_null_or_empty_inputs () {
        $imcResult = $this->imcController->calculateImc(null, 0);
        $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

        $imcResult = $this->imcController->calculateImc(0, null);
        $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

        $imcResult = $this->imcController->calculateImc(null, null);
        $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);
    }

    // OBTER O IMC E CLASSIFICAR
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_get_an_bmi_range() {
        $weight = 68;
        $height = 1.68;

        $imcResult = $this->imcController->calculateImc($weight, $height);

        $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
        $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

        $this->assertEquals('Peso normal', $imcResult['BMIrange']);

        $weight = 54;
        $height = 1.78;

        $imcResult = $this->imcController->calculateImc($weight, $height);

        $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
        $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

        $this->assertEquals('Baixo peso', $imcResult['BMIrange']);


        $weight = 70;
        $height = 1.65;

        $imcResult = $this->imcController->calculateImc($weight, $height);

        $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
        $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

        $this->assertEquals('Sobrepeso', $imcResult['BMIrange']);


        $weight = 90;
        $height = 1.70;

        $imcResult = $this->imcController->calculateImc($weight, $height);

        $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
        $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

        $this->assertEquals('Obesidade grau I', $imcResult['BMIrange']);


        $weight = 102;
        $height = 1.68;

        $imcResult = $this->imcController->calculateImc($weight, $height);

        $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
        $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

        $this->assertEquals('Obesidade grau II', $imcResult['BMIrange']);


        $weight = 108;
        $height = 1.62;

        $imcResult = $this->imcController->calculateImc($weight, $height);

        $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
        $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC.', $imcResult['BMIrange']);

        $this->assertEquals('Obesidade grau III', $imcResult['BMIrange']);

    }

    // SALVAR O IMC
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_save_bmi() {
        $imcResult = $this->imcController->calculateImc(68, 1.68);
        $this->assertStringNotContainsString("Por favor, informe peso e altura para obter o seu IMC.", $imcResult["BMIrange"]);

        $this->mockImcModel->expects($this->once())->method('createImc')->with($this->equalTo(68),$this->equalTo(1.68))->willReturn(true);

        $result = $this->imcController->saveIMC(68, 1.68, $imcResult['imc']);

        $this->assertTrue($result); 
    }
}

?>