<?php

namespace Database\Seeders;

use App\Models\GameTrait;
use Illuminate\Database\Seeder;

class GameTraitSeeder extends Seeder
{
    /**
     * Single source of truth for trait data, also consumed by ModifierSeeder
     * (each entry's `modifiers` key) so the two seeders never drift apart.
     */
    public static function definitions(): array
    {
        return [
            // ── Traços de Atributo (antigo point-buy, agora rarity=common) ──
            ['slug' => 'poderoso', 'name' => 'Poderoso', 'category' => 'body', 'rarity' => 'common', 'description' => 'Excepcionalmente forte.', 'mechanical_effect' => '+0.5 Poder', 'sustento_cost' => 2, 'max_selections' => 2, 'modifiers' => [['attribute' => 'poder', 'operation' => 'add', 'value' => 0.5]]],
            ['slug' => 'gracioso', 'name' => 'Gracioso', 'category' => 'body', 'rarity' => 'common', 'description' => 'Excepcionalmente fino e ágil.', 'mechanical_effect' => '+0.5 Graça', 'sustento_cost' => 2, 'max_selections' => 2, 'modifiers' => [['attribute' => 'graca', 'operation' => 'add', 'value' => 0.5], ['attribute' => 'fofo', 'operation' => 'add', 'value' => 0.5]]],
            ['slug' => 'duradouro', 'name' => 'Duradouro', 'category' => 'body', 'rarity' => 'common', 'description' => 'Resiliente e resistente.', 'mechanical_effect' => '+0.5 Casca', 'sustento_cost' => 2, 'max_selections' => 2, 'modifiers' => [['attribute' => 'casca', 'operation' => 'add', 'value' => 0.5]]],
            ['slug' => 'perspicaz', 'name' => 'Perspicaz', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Perceptivo e inteligente.', 'mechanical_effect' => '+0.5 Saber', 'sustento_cost' => 2, 'max_selections' => 2, 'modifiers' => [['attribute' => 'saber', 'operation' => 'add', 'value' => 0.5]]],
            ['slug' => 'fragil', 'name' => 'Frágil', 'category' => 'body', 'rarity' => 'common', 'description' => 'Delicado, casca fina.', 'mechanical_effect' => '-1 Casca', 'sustento_cost' => -3, 'max_selections' => 2, 'modifiers' => [['attribute' => 'casca', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'fraco', 'name' => 'Fraco', 'category' => 'body', 'rarity' => 'common', 'description' => 'Pouca força física.', 'mechanical_effect' => '-1 Poder', 'sustento_cost' => -3, 'max_selections' => 2, 'modifiers' => [['attribute' => 'poder', 'operation' => 'subtract', 'value' => 1], ['attribute' => 'fofo', 'operation' => 'add', 'value' => 0.5]]],
            ['slug' => 'lindo', 'name' => 'Lindo', 'category' => 'social', 'rarity' => 'common', 'description' => 'Agradável aos sentidos.', 'mechanical_effect' => '+1 Fofo', 'sustento_cost' => 1, 'max_selections' => 2, 'modifiers' => [['attribute' => 'fofo', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'assustador-traco', 'name' => 'Assustador', 'category' => 'social', 'rarity' => 'common', 'description' => 'Desconfortante e ameaçador.', 'mechanical_effect' => '+1 Assustador', 'sustento_cost' => 1, 'max_selections' => 2, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'lento', 'name' => 'Lento', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Mais devagar que a média.', 'mechanical_effect' => '-1 Velocidade', 'sustento_cost' => -2, 'max_selections' => 2, 'modifiers' => [['attribute' => 'velocidade', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'agil', 'name' => 'Ágil', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Rápido e esperto.', 'mechanical_effect' => '+1 Velocidade', 'sustento_cost' => 2, 'max_selections' => 2, 'modifiers' => [['attribute' => 'velocidade', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'saudavel', 'name' => 'Saudável', 'category' => 'body', 'rarity' => 'common', 'description' => 'Raça excepcionalmente saudável.', 'mechanical_effect' => '+1 Coração máximo', 'sustento_cost' => 4, 'max_selections' => 1, 'modifiers' => [['attribute' => 'coracao', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'enfermo', 'name' => 'Enfermo', 'category' => 'body', 'rarity' => 'common', 'description' => 'Dias de glória já passaram.', 'mechanical_effect' => '-1 Coração máximo', 'sustento_cost' => -4, 'max_selections' => 1, 'modifiers' => [['attribute' => 'coracao', 'operation' => 'subtract', 'value' => 1]]],

            // ── Traços Especiais (antigo traçosEspeciais + subTraços) ──
            ['slug' => 'ferrao', 'name' => 'Ferrão', 'category' => 'body', 'rarity' => 'common', 'description' => 'Arma natural que causa 3 Dano ao Longo do Tempo (DoT). -2 para acertar se não estiver voando ou agarrando.', 'sustento_cost' => 3, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 0.5]], 'subs' => [
                ['slug' => 'cauda-preensil', 'name' => 'Cauda Preênsil', 'category' => 'body', 'rarity' => 'common', 'description' => 'O ferrão fica na ponta de uma cauda, negando a penalidade de -2 para acertar.', 'sustento_cost' => 2, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 0.5]]],
            ]],
            ['slug' => 'mandibulas-esmagadoras', 'name' => 'Mandíbulas Esmagadoras', 'category' => 'body', 'rarity' => 'common', 'description' => 'Arma natural de mordida que causa 2 de dano. Pode agarrar como se fosse um membro.', 'sustento_cost' => 1, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 0.5]], 'subs' => [
                ['slug' => 'mandibulas-extralargas', 'name' => 'Mandíbulas Extra-largas', 'category' => 'body', 'rarity' => 'common', 'description' => 'Dano 3 em vez de 2, +2 para agarrar. Peso 1.', 'sustento_cost' => 2, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 0.5], ['attribute' => 'fofo', 'operation' => 'subtract', 'value' => 0.5]]],
            ]],
            ['slug' => 'projetil-natural', 'name' => 'Projétil Natural', 'category' => 'body', 'rarity' => 'common', 'description' => 'Dispara um projétil do corpo. Dano 2, alcance 4. Tipo: Funda.', 'sustento_cost' => 4, 'subs' => [
                ['slug' => 'tiro-debilitante', 'name' => 'Tiro Debilitante', 'category' => 'body', 'rarity' => 'common', 'description' => 'Reduz um atributo primário, barra ou velocidade em 1 (Casca reduz).', 'sustento_cost' => 0],
                ['slug' => 'fluidos', 'name' => 'Fluidos', 'category' => 'body', 'rarity' => 'common', 'description' => 'Aplica efeito de frasco comum no lugar do dano.', 'sustento_cost' => 2],
                ['slug' => 'tiro-pesado', 'name' => 'Tiro Pesado', 'category' => 'body', 'rarity' => 'common', 'description' => '+1 de dano, considerado arma pesada.', 'sustento_cost' => 0],
            ]],
            ['slug' => 'garras-afiadas', 'name' => 'Garras Afiadas', 'category' => 'body', 'rarity' => 'common', 'description' => 'As pontas dos dedos têm garras que causam 1 de dano, podem ser usadas em conjunto com outra arma (+1 de dano base).', 'sustento_cost' => 1],
            ['slug' => 'batida', 'name' => 'Batida', 'category' => 'body', 'rarity' => 'common', 'description' => 'Ataque de carga que causa 2/3/4 de dano (valor de Médio usado como custo fixo). -2 para aparar. Médio tem Peso 1, Grande é pesada.', 'sustento_cost' => 2],
            ['slug' => 'espinhos', 'name' => 'Espinhos', 'category' => 'defense', 'rarity' => 'common', 'description' => 'Corpo coberto de espinhos. Arma natural 2 de dano. Atacantes corpo a corpo sofrem dano amortecível igual à Estamina gasta.', 'sustento_cost' => 3, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 0.5]]],
            ['slug' => 'voo-inferior', 'name' => 'Voo Inferior', 'category' => 'movement', 'rarity' => 'remarkable', 'description' => 'Pode voar gastando 1 Estamina por movimento. Deve pousar ao fim do turno ou gastar 1 Estamina para flutuar.', 'sustento_cost' => 4, 'subs' => [
                ['slug' => 'aereo', 'name' => 'Aéreo', 'category' => 'movement', 'rarity' => 'remarkable', 'description' => 'Especializado em voo. Velocidade em solo -2, velocidade de voo +2.', 'sustento_cost' => 0],
                ['slug' => 'voo-completo', 'name' => 'Voo', 'category' => 'movement', 'rarity' => 'remarkable', 'description' => 'Pode permanecer no ar; Estamina não regenera até pousar.', 'sustento_cost' => 4],
            ]],
            ['slug' => 'escalada', 'name' => 'Escalada', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Pode se mover na velocidade máxima enquanto escala, inclusive tetos.', 'sustento_cost' => 2],
            ['slug' => 'salto', 'name' => 'Salto', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Uma vez por rodada, gasta 3 Estamina para saltar até 10 quadrados. Pode ser usado no lugar da esquiva.', 'sustento_cost' => 4],
            ['slug' => 'visao-noturna', 'name' => 'Visão Noturna', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Enxerga na escuridão como se estivesse iluminado. Olhos brilham fracamente.', 'sustento_cost' => 2, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 0.5]]],
            ['slug' => 'faro', 'name' => 'Faro', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Pode "ver" pelo olfato. Enxerga no escuro, mas coisas fedorentas atrapalham.', 'sustento_cost' => 4],
            ['slug' => 'senso-tremor', 'name' => 'Senso de Tremor', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Vê através do solo/paredes enquanto em contato. Insetos aéreos têm -2 para acertar.', 'sustento_cost' => 4],
            ['slug' => 'corpo-macio', 'name' => 'Corpo Macio', 'category' => 'body', 'rarity' => 'remarkable', 'description' => 'Não tem exoesqueleto. Não pode usar Casca para amortecer, mas +4 Coração. Cura +2 Corações por descanso.', 'sustento_cost' => 0, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 0.5], ['attribute' => 'fofo', 'operation' => 'add', 'value' => 0.5], ['attribute' => 'coracao', 'operation' => 'add', 'value' => 4]], 'subs' => [
                ['slug' => 'concha-externa', 'name' => 'Concha Externa', 'category' => 'body', 'rarity' => 'remarkable', 'description' => 'Pode recuar para uma concha com Absorção igual à Casca base.', 'sustento_cost' => 5],
            ]],
            ['slug' => 'sanguessuga', 'name' => 'Sanguessuga', 'category' => 'body', 'rarity' => 'remarkable', 'description' => 'Pode sugar sangue com mordida (0 de dano) para ganhar 5 Bucho, alvo perde 10.', 'sustento_cost' => 4],
            ['slug' => 'bracos-extras', 'name' => 'Braços Extras', 'category' => 'body', 'rarity' => 'common', 'description' => 'Um par extra de braços igualmente funcionais.', 'sustento_cost' => 4],
            ['slug' => 'sem-braco', 'name' => 'Sem Braço', 'category' => 'body', 'rarity' => 'common', 'description' => 'Não tem braços. Não pode segurar armas ou escudos. Tarefas manuais muito difíceis.', 'sustento_cost' => -10],
            ['slug' => 'camuflagem', 'name' => 'Camuflagem', 'category' => 'defense', 'rarity' => 'common', 'description' => '+2 em Furtividade em um tipo de terreno (ex: floresta, deserto).', 'sustento_cost' => 1],
            ['slug' => 'venenoso', 'name' => 'Venenoso', 'category' => 'defense', 'rarity' => 'common', 'description' => 'Corpo tóxico. Mordedores sofrem DoT 1. Carne não comestível (dano por Bucho).', 'sustento_cost' => 3],
            ['slug' => 'pelugem-palida', 'name' => 'Pelugem Pálida', 'category' => 'mystic', 'rarity' => 'common', 'description' => 'Recupera 1 Alma por descanso. Sente presença de espíritos/magia poderosa.', 'sustento_cost' => 3, 'modifiers' => [['attribute' => 'fofo', 'operation' => 'add', 'value' => 0.5]]],
            ['slug' => 'musica', 'name' => 'Música', 'category' => 'social', 'rarity' => 'common', 'description' => 'Cria melodia calmante (+1 Fofo) ou arrepiante (+1 Assustador) para testes sociais.', 'sustento_cost' => 1],

            // ── Traço Raro (exemplo do spec) ──
            ['slug' => 'sangue-dos-ancestrais', 'name' => 'Sangue dos Ancestrais', 'category' => 'mystic', 'rarity' => 'rare', 'description' => 'Seu sangue tem propriedades curativas.', 'mechanical_effect' => 'Quando outro inseto bebe seu sangue, ganha 1 Coração de Sangue Vital.', 'sustento_cost' => 2],

            // ── Traços de Personalidade (obrigatórios — escolha exatamente 2) ──
            ['slug' => 'corajoso', 'name' => 'Corajoso', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Você nunca recua de um desafio.', 'mechanical_effect' => '+1 em testes contra medo. Pode gastar 1 Estamina para ignorar 1 Desequilíbrio.', 'roleplay_obligation' => 'Você deve enfrentar perigos de frente, mesmo quando seria mais sábio fugir.', 'sustento_cost' => 0],
            ['slug' => 'curioso', 'name' => 'Curioso', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Você não resiste a um mistério.', 'mechanical_effect' => '+1 em testes de Saber para investigar. Pode fazer uma pergunta extra ao Mestre.', 'roleplay_obligation' => 'Você deve investigar tudo que parece interessante, mesmo que perigoso.', 'sustento_cost' => 0],
            ['slug' => 'gentil', 'name' => 'Gentil', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Você se importa genuinamente com os outros.', 'mechanical_effect' => '+1 em testes sociais para ajudar ou consolar alguém.', 'roleplay_obligation' => 'Você deve ajudar quem está em apuros, mesmo a um custo pessoal.', 'sustento_cost' => 0],
            ['slug' => 'vingativo', 'name' => 'Vingativo', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Ofensas não ficam sem resposta.', 'mechanical_effect' => '+1 em ataques contra quem já te feriu antes.', 'roleplay_obligation' => 'Você deve perseguir quem te prejudicou até resolver a questão.', 'sustento_cost' => 0],
            ['slug' => 'leal', 'name' => 'Leal', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Seus aliados podem contar com você até o fim.', 'mechanical_effect' => '+1 em testes para proteger ou resgatar um aliado.', 'roleplay_obligation' => 'Você nunca abandona um aliado em perigo, mesmo contra ordens.', 'sustento_cost' => 0],
        ];
    }

    public function run(): void
    {
        // Sustento não é mais um orçamento gasto por traços — é só a Ração necessária
        // por descanso, fixa por tamanho. Traços são livres; o balanceamento vem dos
        // próprios atributos que cada um modifica.
        foreach (self::definitions() as $definition) {
            $subs = $definition['subs'] ?? [];
            $parentData = collect($definition)->except(['modifiers', 'subs'])->all();
            $parentData['sustento_cost'] = 0;

            $parent = GameTrait::updateOrCreate(['slug' => $parentData['slug']], $parentData);

            foreach ($subs as $sub) {
                $subData = collect($sub)->except(['modifiers'])->all();
                $subData['prerequisite_trait_id'] = $parent->id;
                $subData['sustento_cost'] = 0;

                GameTrait::updateOrCreate(['slug' => $subData['slug']], $subData);
            }
        }
    }
}
