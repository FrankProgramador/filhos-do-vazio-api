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
            // ── Traços de Atributo (point-buy, rarity=common, um único pick cada) ──
            // Poder
            ['slug' => 'poderoso', 'name' => 'Poderoso', 'category' => 'body', 'rarity' => 'common', 'description' => 'Excepcionalmente forte.', 'mechanical_effect' => '+1 Poder', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'poder', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'bruto', 'name' => 'Bruto', 'category' => 'body', 'rarity' => 'common', 'description' => 'Músculos onde deveria haver charme.', 'mechanical_effect' => '+1 Poder, -1 Fofo', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'poder', 'operation' => 'add', 'value' => 1], ['attribute' => 'fofo', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'encouracado', 'name' => 'Encouraçado', 'category' => 'body', 'rarity' => 'common', 'description' => 'Massa muscular pesa na agilidade.', 'mechanical_effect' => '+1 Poder, -1 Graça', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'poder', 'operation' => 'add', 'value' => 1], ['attribute' => 'graca', 'operation' => 'subtract', 'value' => 1]]],

            // Graça
            ['slug' => 'gracioso', 'name' => 'Gracioso', 'category' => 'body', 'rarity' => 'common', 'description' => 'Excepcionalmente fino e ágil.', 'mechanical_effect' => '+1 Graça', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'graca', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'fragil', 'name' => 'Frágil', 'category' => 'body', 'rarity' => 'common', 'description' => 'Leve demais para aguentar.', 'mechanical_effect' => '+1 Graça, -1 Casca', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'graca', 'operation' => 'add', 'value' => 1], ['attribute' => 'casca', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'escorregadio', 'name' => 'Escorregadio', 'category' => 'body', 'rarity' => 'common', 'description' => 'Difícil de pegar, difícil de gostar.', 'mechanical_effect' => '+1 Graça, -1 Fofo', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'graca', 'operation' => 'add', 'value' => 1], ['attribute' => 'fofo', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'refinado', 'name' => 'Refinado', 'category' => 'body', 'rarity' => 'common', 'description' => 'Agilidade vira elegância — perde peso de presença.', 'mechanical_effect' => '+1 Graça, +1 Fofo, -1 Assustador', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'graca', 'operation' => 'add', 'value' => 1], ['attribute' => 'fofo', 'operation' => 'add', 'value' => 1], ['attribute' => 'assustador', 'operation' => 'subtract', 'value' => 1]]],

            // Casca
            ['slug' => 'duradouro', 'name' => 'Duradouro', 'category' => 'body', 'rarity' => 'common', 'description' => 'Resiliente e resistente.', 'mechanical_effect' => '+1 Casca', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'casca', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'lento', 'name' => 'Lento', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Pesado demais para correr.', 'mechanical_effect' => '+1 Casca, -1 Deslocamento', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'casca', 'operation' => 'add', 'value' => 1], ['attribute' => 'velocidade', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'obtuso', 'name' => 'Obtuso', 'category' => 'body', 'rarity' => 'common', 'description' => 'Carapaça grossa por dentro também.', 'mechanical_effect' => '+1 Casca, -1 Saber', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'casca', 'operation' => 'add', 'value' => 1], ['attribute' => 'saber', 'operation' => 'subtract', 'value' => 1]]],

            // Saber
            ['slug' => 'perspicaz', 'name' => 'Perspicaz', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Perceptivo e inteligente.', 'mechanical_effect' => '+1 Saber', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'saber', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'estudioso', 'name' => 'Estudioso', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Passou a vida lendo, não treinando.', 'mechanical_effect' => '+1 Saber, -1 Poder', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'saber', 'operation' => 'add', 'value' => 1], ['attribute' => 'poder', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'ansioso', 'name' => 'Ansioso', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Percebe demais, parece estranho aos outros.', 'mechanical_effect' => '+1 Saber, -1 Fofo', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'saber', 'operation' => 'add', 'value' => 1], ['attribute' => 'fofo', 'operation' => 'subtract', 'value' => 1]]],

            // Fofo
            ['slug' => 'lindo', 'name' => 'Lindo', 'category' => 'social', 'rarity' => 'common', 'description' => 'Agradável aos sentidos.', 'mechanical_effect' => '+1 Fofo', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'fofo', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'fraco', 'name' => 'Fraco', 'category' => 'social', 'rarity' => 'common', 'description' => 'Fragilidade física vira disarme social.', 'mechanical_effect' => '+1 Fofo, -1 Poder', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'fofo', 'operation' => 'add', 'value' => 1], ['attribute' => 'poder', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'ingenuo', 'name' => 'Ingênuo', 'category' => 'social', 'rarity' => 'common', 'description' => 'Confiante demais para desconfiar.', 'mechanical_effect' => '+1 Fofo, -1 Saber', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'fofo', 'operation' => 'add', 'value' => 1], ['attribute' => 'saber', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'medroso', 'name' => 'Medroso', 'category' => 'social', 'rarity' => 'common', 'description' => 'Inofensivo demais para intimidar.', 'mechanical_effect' => '+1 Fofo, -1 Assustador', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'fofo', 'operation' => 'add', 'value' => 1], ['attribute' => 'assustador', 'operation' => 'subtract', 'value' => 1]]],

            // Assustador
            ['slug' => 'ameacador', 'name' => 'Ameaçador', 'category' => 'social', 'rarity' => 'common', 'description' => 'Desconfortante e ameaçador.', 'mechanical_effect' => '+1 Assustador', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'intimidante', 'name' => 'Intimidante', 'category' => 'social', 'rarity' => 'common', 'description' => 'Presença que afasta, não atrai.', 'mechanical_effect' => '+1 Assustador, -1 Fofo', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1], ['attribute' => 'fofo', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'cicatrizado', 'name' => 'Cicatrizado', 'category' => 'social', 'rarity' => 'common', 'description' => 'Marcas que pesam no corpo.', 'mechanical_effect' => '+1 Assustador, -1 Graça', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1], ['attribute' => 'graca', 'operation' => 'subtract', 'value' => 1]]],

            // Deslocamento
            ['slug' => 'agil', 'name' => 'Ágil', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Rápido e esperto.', 'mechanical_effect' => '+1 Deslocamento', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'velocidade', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'leviano', 'name' => 'Leviano', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Rápido porque não tem peso para carregar.', 'mechanical_effect' => '+1 Deslocamento, -1 Casca', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'velocidade', 'operation' => 'add', 'value' => 1], ['attribute' => 'casca', 'operation' => 'subtract', 'value' => 1]]],
            ['slug' => 'nervoso', 'name' => 'Nervoso', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Sempre em movimento, nunca parado para pensar.', 'mechanical_effect' => '+1 Deslocamento, -1 Saber', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'velocidade', 'operation' => 'add', 'value' => 1], ['attribute' => 'saber', 'operation' => 'subtract', 'value' => 1]]],

            // Corações
            ['slug' => 'saudavel', 'name' => 'Saudável', 'category' => 'body', 'rarity' => 'common', 'description' => 'Raça excepcionalmente saudável.', 'mechanical_effect' => '+1 Coração máximo', 'sustento_cost' => 0, 'max_selections' => 1, 'modifiers' => [['attribute' => 'coracao', 'operation' => 'add', 'value' => 1]]],

            // ── Traços Especiais (antigo traçosEspeciais + subTraços) ──
            ['slug' => 'ferrao', 'name' => 'Ferrão', 'category' => 'body', 'rarity' => 'common', 'description' => 'Arma natural que causa 3 Dano ao Longo do Tempo (DoT). -2 para acertar se não estiver voando ou agarrando.', 'sustento_cost' => 3, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1]], 'subs' => [
                ['slug' => 'cauda-preensil', 'name' => 'Cauda Preênsil', 'category' => 'body', 'rarity' => 'common', 'description' => 'O ferrão fica na ponta de uma cauda, negando a penalidade de -2 para acertar.', 'sustento_cost' => 2, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1]]],
            ]],
            ['slug' => 'mandibulas-esmagadoras', 'name' => 'Mandíbulas Esmagadoras', 'category' => 'body', 'rarity' => 'common', 'description' => 'Arma natural de mordida que causa 2 de dano. Pode agarrar como se fosse um membro.', 'sustento_cost' => 1, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1]], 'subs' => [
                ['slug' => 'mandibulas-extralargas', 'name' => 'Mandíbulas Extra-largas', 'category' => 'body', 'rarity' => 'common', 'description' => 'Dano 3 em vez de 2, +2 para agarrar. Peso 1.', 'sustento_cost' => 2, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1], ['attribute' => 'fofo', 'operation' => 'subtract', 'value' => 1]]],
            ]],
            ['slug' => 'projetil-natural', 'name' => 'Projétil Natural', 'category' => 'body', 'rarity' => 'common', 'description' => 'Dispara um projétil do corpo. Dano 2, alcance 4. Tipo: Funda.', 'sustento_cost' => 4, 'subs' => [
                ['slug' => 'tiro-debilitante', 'name' => 'Tiro Debilitante', 'category' => 'body', 'rarity' => 'common', 'description' => 'Reduz um atributo primário, barra ou velocidade em 1 (Casca reduz).', 'sustento_cost' => 0],
                ['slug' => 'fluidos', 'name' => 'Fluidos', 'category' => 'body', 'rarity' => 'common', 'description' => 'Aplica efeito de frasco comum no lugar do dano.', 'sustento_cost' => 2],
                ['slug' => 'tiro-pesado', 'name' => 'Tiro Pesado', 'category' => 'body', 'rarity' => 'common', 'description' => '+1 de dano, considerado arma pesada.', 'sustento_cost' => 0],
            ]],
            ['slug' => 'garras-afiadas', 'name' => 'Garras Afiadas', 'category' => 'body', 'rarity' => 'common', 'description' => 'As pontas dos dedos têm garras que causam 1 de dano, podem ser usadas em conjunto com outra arma (+1 de dano base).', 'sustento_cost' => 1],
            ['slug' => 'batida', 'name' => 'Batida', 'category' => 'body', 'rarity' => 'common', 'description' => 'Ataque de carga que causa 2/3/4 de dano (valor de Médio usado como custo fixo). -2 para aparar. Médio tem Peso 1, Grande é pesada.', 'sustento_cost' => 2],
            ['slug' => 'espinhos', 'name' => 'Espinhos', 'category' => 'defense', 'rarity' => 'common', 'description' => 'Corpo coberto de espinhos. Arma natural 2 de dano. Atacantes corpo a corpo sofrem dano amortecível igual à Estamina gasta.', 'sustento_cost' => 3, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'voo-inferior', 'name' => 'Voo Inferior', 'category' => 'movement', 'rarity' => 'remarkable', 'description' => 'Pode voar gastando 1 Estamina por movimento. Deve pousar ao fim do turno ou gastar 1 Estamina para flutuar.', 'sustento_cost' => 4, 'subs' => [
                ['slug' => 'aereo', 'name' => 'Aéreo', 'category' => 'movement', 'rarity' => 'remarkable', 'description' => 'Especializado em voo. Velocidade em solo -2, velocidade de voo +2.', 'sustento_cost' => 0],
                ['slug' => 'voo-completo', 'name' => 'Voo', 'category' => 'movement', 'rarity' => 'remarkable', 'description' => 'Pode permanecer no ar; Estamina não regenera até pousar.', 'sustento_cost' => 4],
            ]],
            ['slug' => 'escalada', 'name' => 'Escalada', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Pode se mover na velocidade máxima enquanto escala, inclusive tetos.', 'sustento_cost' => 2],
            ['slug' => 'salto', 'name' => 'Salto', 'category' => 'movement', 'rarity' => 'common', 'description' => 'Uma vez por rodada, gasta 3 Estamina para saltar até 10 quadrados. Pode ser usado no lugar da esquiva.', 'sustento_cost' => 4],
            ['slug' => 'visao-noturna', 'name' => 'Visão Noturna', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Enxerga na escuridão como se estivesse iluminado. Olhos brilham fracamente.', 'sustento_cost' => 2, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'faro', 'name' => 'Faro', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Pode "ver" pelo olfato. Enxerga no escuro, mas coisas fedorentas atrapalham.', 'sustento_cost' => 4],
            ['slug' => 'senso-tremor', 'name' => 'Senso de Tremor', 'category' => 'senses', 'rarity' => 'common', 'description' => 'Vê através do solo/paredes enquanto em contato. Insetos aéreos têm -2 para acertar.', 'sustento_cost' => 4],
            ['slug' => 'corpo-macio', 'name' => 'Corpo Macio', 'category' => 'body', 'rarity' => 'remarkable', 'description' => 'Não tem exoesqueleto. Não pode usar Casca para amortecer, mas +4 Coração. Cura +2 Corações por descanso.', 'sustento_cost' => 0, 'modifiers' => [['attribute' => 'assustador', 'operation' => 'add', 'value' => 1], ['attribute' => 'fofo', 'operation' => 'add', 'value' => 1], ['attribute' => 'coracao', 'operation' => 'add', 'value' => 4]], 'subs' => [
                ['slug' => 'concha-externa', 'name' => 'Concha Externa', 'category' => 'body', 'rarity' => 'remarkable', 'description' => 'Pode recuar para uma concha com Absorção igual à Casca base.', 'sustento_cost' => 5],
            ]],
            ['slug' => 'sanguessuga', 'name' => 'Sanguessuga', 'category' => 'body', 'rarity' => 'remarkable', 'description' => 'Pode sugar sangue com mordida (0 de dano) para ganhar 5 Bucho, alvo perde 10.', 'sustento_cost' => 4],
            ['slug' => 'bracos-extras', 'name' => 'Braços Extras', 'category' => 'body', 'rarity' => 'common', 'description' => 'Um par extra de braços igualmente funcionais.', 'sustento_cost' => 4],
            ['slug' => 'sem-braco', 'name' => 'Sem Braço', 'category' => 'body', 'rarity' => 'common', 'description' => 'Não tem braços. Não pode segurar armas ou escudos. Tarefas manuais muito difíceis.', 'sustento_cost' => -10],
            ['slug' => 'camuflagem', 'name' => 'Camuflagem', 'category' => 'defense', 'rarity' => 'common', 'description' => '+2 em Furtividade em um tipo de terreno (ex: floresta, deserto).', 'sustento_cost' => 1],
            ['slug' => 'venenoso', 'name' => 'Venenoso', 'category' => 'defense', 'rarity' => 'common', 'description' => 'Corpo tóxico. Mordedores sofrem DoT 1. Carne não comestível (dano por Bucho).', 'sustento_cost' => 3],
            ['slug' => 'pelugem-palida', 'name' => 'Pelugem Pálida', 'category' => 'mystic', 'rarity' => 'common', 'description' => 'Recupera 1 Alma por descanso. Sente presença de espíritos/magia poderosa.', 'sustento_cost' => 3, 'modifiers' => [['attribute' => 'fofo', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'musica', 'name' => 'Música', 'category' => 'social', 'rarity' => 'common', 'description' => 'Cria melodia calmante (+1 Fofo) ou arrepiante (+1 Assustador) para testes sociais.', 'sustento_cost' => 1],

            // ── Traço Raro (exemplo do spec) ──
            ['slug' => 'sangue-dos-ancestrais', 'name' => 'Sangue dos Ancestrais', 'category' => 'mystic', 'rarity' => 'rare', 'description' => 'Seu sangue tem propriedades curativas.', 'mechanical_effect' => 'Quando outro inseto bebe seu sangue, ganha 1 Coração de Sangue Vital.', 'sustento_cost' => 2],

            // ── Traços de Personalidade (obrigatórios — escolha exatamente 2) ──
            ['slug' => 'corajoso', 'name' => 'Corajoso', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Você nunca recua de um desafio.', 'mechanical_effect' => '+1 contra medo. Gaste 1 Estamina para ignorar 1 Desequilíbrio.', 'roleplay_obligation' => 'Enfrenta perigos de frente, mesmo quando não deveria.', 'sustento_cost' => 0],
            ['slug' => 'curioso', 'name' => 'Curioso', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Você não resiste a um mistério.', 'mechanical_effect' => '+1 em Saber para investigar. Pergunta extra ao GM por cena.', 'roleplay_obligation' => 'Investiga tudo que parece interessante, mesmo que perigoso.', 'sustento_cost' => 0],
            ['slug' => 'gentil', 'name' => 'Gentil', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Você se importa genuinamente com quem conhece.', 'mechanical_effect' => '+1 em testes sociais para ajudar ou consolar.', 'roleplay_obligation' => 'Ajuda quem está em apuros — mas apenas quem já conhece.', 'sustento_cost' => 0],
            ['slug' => 'heroi', 'name' => 'Herói', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Injustiça, para você, é problema pessoal — de qualquer um.', 'mechanical_effect' => '+1 para proteger ou defender. +1 Fofo permanente.', 'roleplay_obligation' => 'Intervém em injustiças com qualquer um, inclusive desconhecidos.', 'sustento_cost' => 0, 'modifiers' => [['attribute' => 'fofo', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'protetor', 'name' => 'Protetor', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Há um aliado que você jurou nunca deixar cair.', 'mechanical_effect' => '+1 em defesas para proteger um aliado específico.', 'roleplay_obligation' => 'Nunca abandona um aliado em perigo, mesmo contra ordens.', 'sustento_cost' => 0],
            ['slug' => 'vingativo', 'name' => 'Vingativo', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Ofensas não ficam sem resposta.', 'mechanical_effect' => '+1 em ataques contra quem já te feriu.', 'roleplay_obligation' => 'Persegue quem te prejudicou até acertar a conta.', 'sustento_cost' => 0],
            ['slug' => 'leal', 'name' => 'Leal', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Seus aliados podem contar com você até o fim.', 'mechanical_effect' => '+1 para proteger ou resgatar um aliado.', 'roleplay_obligation' => 'Nunca abandona um aliado em perigo, mesmo contra ordens.', 'sustento_cost' => 0],
            ['slug' => 'obstinado', 'name' => 'Obstinado', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Falhar não é o mesmo que desistir.', 'mechanical_effect' => 'Rerola uma vez por cena ao falhar.', 'roleplay_obligation' => 'Nunca aceita derrota sem tentar de novo.', 'sustento_cost' => 0],
            ['slug' => 'desconfiado', 'name' => 'Desconfiado', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Toda mão estendida pode esconder uma faca.', 'mechanical_effect' => '+1 para detectar mentiras ou armadilhas.', 'roleplay_obligation' => 'Raramente confia em alguém à primeira vista.', 'sustento_cost' => 0],
            ['slug' => 'divida-antiga', 'name' => 'Dívida Antiga', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Contas em aberto te incomodam mais que perigo.', 'mechanical_effect' => '+1 em negociação quando o preço é seu.', 'roleplay_obligation' => 'Não deixa dívidas abertas — nem as que te devem.', 'sustento_cost' => 0],
            ['slug' => 'metodico', 'name' => 'Metódico', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Cada passo só vem depois de um plano.', 'mechanical_effect' => '+1 quando age conforme plano declarado antes da cena.', 'roleplay_obligation' => 'Precisa planejar antes de agir — impulso custa -1.', 'sustento_cost' => 0],
            ['slug' => 'devoto', 'name' => 'Devoto', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Sua fé é a coluna que te mantém em pé.', 'mechanical_effect' => '+1 Alma máxima permanente.', 'roleplay_obligation' => 'Defende sua fé. Crise severa perde o bônus até renovar o voto.', 'sustento_cost' => 0, 'modifiers' => [['attribute' => 'alma', 'operation' => 'add', 'value' => 1]]],
            ['slug' => 'cleptomaniaco', 'name' => 'Cleptomaníaco', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Coisas brilhantes têm o hábito de desaparecer perto de você.', 'mechanical_effect' => '+1 dado em furto.', 'roleplay_obligation' => 'Rola Saber (2 sucessos) para não tentar roubar algo interessante.', 'sustento_cost' => 0],
            ['slug' => 'covarde', 'name' => 'Covarde', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'Sobreviver importa mais que parecer corajoso.', 'mechanical_effect' => '+1 dado em fuga/esquiva quando em desvantagem.', 'roleplay_obligation' => 'Rola Saber (1 sucesso) para não recuar quando em desvantagem.', 'sustento_cost' => 0],
            ['slug' => 'invejoso', 'name' => 'Invejoso', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'O que os outros têm, você quer.', 'mechanical_effect' => '+1 para obter algo que pertence a outro.', 'roleplay_obligation' => 'Deve agir para conseguir o que deseja em 2 cenas ou -1 em tudo.', 'sustento_cost' => 0],
            ['slug' => 'mentiroso-compulsivo', 'name' => 'Mentiroso Compulsivo', 'category' => 'personality', 'rarity' => 'personality', 'description' => 'A verdade é só uma opção entre várias.', 'mechanical_effect' => '+1 em enganação.', 'roleplay_obligation' => 'Rola Saber (1 sucesso) para não mentir quando a verdade seria melhor.', 'sustento_cost' => 0],
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
