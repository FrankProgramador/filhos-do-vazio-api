<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\AbilitySource;
use App\Models\Trigger;
use App\Models\Trilha;
use Illuminate\Database\Seeder;

class AbilitySeeder extends Seeder
{
    /**
     * Uma entrada por habilidade de trilha (nível 1 a 3), com seus triggers
     * embutidos — mesmo padrão de GameTraitSeeder::definitions() (fonte única
     * também consumida indiretamente por quem precisar inspecionar os dados).
     */
    public static function definitions(): array
    {
        return [
            // ── Ferrão ───────────────────────────────────────────────────────
            ['trilha_slug' => 'ferrao-trilha', 'level' => 1, 'slug' => 'quebra-guarda', 'name' => 'Quebra-Guarda', 'type' => 'passive',
                'description' => '4s contam como sucessos contra oponentes que você já causou dano.', 'triggers' => [
                    ['slug' => 'quebra-guarda-on-hit', 'name' => 'on_hit', 'condition_type' => 'custom', 'condition_value' => ['note' => 'target_has_taken_damage_from_ally'], 'target_type' => 'target'],
                ]],
            ['trilha_slug' => 'ferrao-trilha', 'level' => 2, 'slug' => 'postura-de-luta', 'name' => 'Postura de Luta', 'type' => 'passive',
                'description' => 'Inimigos que entram em um quadrado adjacente a você provocam um ataque de oportunidade gratuito.', 'triggers' => [
                    ['slug' => 'postura-de-luta-on-enemy-enters-adjacent', 'name' => 'on_enemy_enters_adjacent', 'condition_type' => 'custom', 'condition_value' => ['distance' => 1], 'target_type' => 'enemies'],
                ]],
            ['trilha_slug' => 'ferrao-trilha', 'level' => 3, 'slug' => 'mestre-marcial', 'name' => 'Mestre Marcial', 'type' => 'passive',
                'description' => 'Ganha +1 Arte de Arma por turno.', 'triggers' => []],

            // ── Agulha ───────────────────────────────────────────────────────
            ['trilha_slug' => 'agulha-trilha', 'level' => 1, 'slug' => 'ataques-rapidos', 'name' => 'Ataques Rápidos', 'type' => 'passive',
                'description' => 'Ataca corpo a corpo usando Graça ao invés de Poder.', 'triggers' => []],
            ['trilha_slug' => 'agulha-trilha', 'level' => 1, 'slug' => 'estocada-afiada', 'name' => 'Estocada Afiada', 'type' => 'active',
                'description' => 'Ganha +1 de alcance e move 1 quadrado ao atacar.', 'triggers' => [
                    ['slug' => 'estocada-afiada-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'agulha-trilha', 'level' => 2, 'slug' => 'danca-de-batalha', 'name' => 'Dança de Batalha', 'type' => 'passive',
                'description' => 'Ganha Momentum ao avançar ou pular.', 'triggers' => [
                    ['slug' => 'danca-de-batalha-on-move', 'name' => 'on_move', 'condition_type' => 'custom', 'condition_value' => ['note' => 'avanço ou pulo'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'agulha-trilha', 'level' => 3, 'slug' => 'esquiva-felina', 'name' => 'Esquiva Felina', 'type' => 'passive',
                'description' => '6s contam como 2 sucessos ao esquivar.', 'triggers' => [
                    ['slug' => 'esquiva-felina-on-dodge', 'name' => 'on_dodge', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],

            // ── Presa ────────────────────────────────────────────────────────
            ['trilha_slug' => 'presa-trilha', 'level' => 1, 'slug' => 'ataque-poderoso', 'name' => 'Ataque Poderoso', 'type' => 'active',
                'description' => 'Gastando 3+ Estamina, causa +1 de dano (+2 se arma pesada).', 'activation_cost' => ['estamina' => 3], 'triggers' => [
                    ['slug' => 'ataque-poderoso-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'target'],
                ]],
            ['trilha_slug' => 'presa-trilha', 'level' => 2, 'slug' => 'folego-extra', 'name' => 'Fôlego Extra', 'type' => 'passive',
                'description' => 'Ganha 1 Estamina ao fim do turno se estiver sem Estamina.', 'triggers' => [
                    ['slug' => 'folego-extra-on-turn-end', 'name' => 'on_turn_end', 'condition_type' => 'custom', 'condition_value' => ['note' => 'stamina == 0'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'presa-trilha', 'level' => 2, 'slug' => 'desenterrar', 'name' => 'Desenterrar', 'type' => 'active',
                'description' => 'Ataca um quadrado vazio, criando terreno difícil.', 'triggers' => [
                    ['slug' => 'desenterrar-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'area'],
                ]],
            ['trilha_slug' => 'presa-trilha', 'level' => 3, 'slug' => 'forca-controlada', 'name' => 'Força Controlada', 'type' => 'passive',
                'description' => 'Estamina dedicada remove Desequilíbrio.', 'triggers' => []],

            // ── Gancho ───────────────────────────────────────────────────────
            ['trilha_slug' => 'gancho-trilha', 'level' => 1, 'slug' => 'foice-sutil', 'name' => 'Foice Sutil', 'type' => 'passive',
                'description' => 'Ataca corpo a corpo usando Graça.', 'triggers' => []],
            ['trilha_slug' => 'gancho-trilha', 'level' => 1, 'slug' => 'puxar-e-empurrar', 'name' => 'Puxar e Empurrar', 'type' => 'active',
                'description' => '-1 dano para mover o alvo 1 quadrado.', 'triggers' => [
                    ['slug' => 'puxar-e-empurrar-on-hit', 'name' => 'on_hit', 'condition_type' => 'none', 'target_type' => 'target'],
                ]],
            ['trilha_slug' => 'gancho-trilha', 'level' => 2, 'slug' => 'bolsa-de-truques', 'name' => 'Bolsa de Truques', 'type' => 'passive',
                'description' => '+1 Estoque e duas receitas de armadilha.', 'triggers' => []],
            ['trilha_slug' => 'gancho-trilha', 'level' => 2, 'slug' => 'truques-espertos', 'name' => 'Truques Espertos', 'type' => 'active',
                'description' => 'Posiciona uma armadilha a até 3 quadrados de distância.', 'triggers' => [
                    ['slug' => 'truques-espertos-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'area', 'area_params' => ['range' => 3]],
                ]],
            ['trilha_slug' => 'gancho-trilha', 'level' => 3, 'slug' => 'insistencia-mantica', 'name' => 'Insistência Mântica', 'type' => 'active',
                'description' => 'Ataque à distância que puxa o alvo.', 'triggers' => [
                    ['slug' => 'insistencia-mantica-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'target'],
                ]],

            // ── Funda ────────────────────────────────────────────────────────
            ['trilha_slug' => 'funda-trilha', 'level' => 1, 'slug' => 'bom-braco', 'name' => 'Bom Braço', 'type' => 'passive',
                'description' => 'Usa Poder ao invés de Graça para ataques à distância.', 'triggers' => []],
            ['trilha_slug' => 'funda-trilha', 'level' => 1, 'slug' => 'tiro-longo', 'name' => 'Tiro Longo', 'type' => 'active',
                'description' => 'Dobra o alcance do ataque à distância.', 'triggers' => [
                    ['slug' => 'tiro-longo-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'target'],
                ]],
            ['trilha_slug' => 'funda-trilha', 'level' => 2, 'slug' => 'retorno', 'name' => 'Retorno', 'type' => 'passive',
                'description' => 'Um ataque esquivado/defletido ricocheteia para um adjacente.', 'triggers' => [
                    ['slug' => 'retorno-on-dodge', 'name' => 'on_dodge', 'condition_type' => 'custom', 'condition_value' => ['note' => 'ataque esquivado/defletido'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'funda-trilha', 'level' => 3, 'slug' => 'em-cheio', 'name' => 'Em Cheio', 'type' => 'passive',
                'description' => '6s contam como 2 sucessos em ataques à distância.', 'triggers' => [
                    ['slug' => 'em-cheio-on-hit', 'name' => 'on_hit', 'condition_type' => 'custom', 'condition_value' => ['note' => 'ataque à distância'], 'target_type' => 'target'],
                ]],

            // ── Frasco ───────────────────────────────────────────────────────
            ['trilha_slug' => 'frasco-trilha', 'level' => 1, 'slug' => 'arremesso-facil', 'name' => 'Arremesso Fácil', 'type' => 'passive',
                'description' => 'Arremessar frascos não gasta Estamina.', 'triggers' => []],
            ['trilha_slug' => 'frasco-trilha', 'level' => 1, 'slug' => 'guerrilha-quimica', 'name' => 'Guerrilha Química', 'type' => 'passive',
                'description' => '+1 Estoque, +3 receitas de frasco.', 'triggers' => []],
            ['trilha_slug' => 'frasco-trilha', 'level' => 2, 'slug' => 'explosao-controlada', 'name' => 'Explosão Controlada', 'type' => 'active',
                'description' => 'Aumenta em +1 a área de um frasco.', 'triggers' => [
                    ['slug' => 'explosao-controlada-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'area', 'area_params' => ['bonus_range' => 1]],
                ]],
            ['trilha_slug' => 'frasco-trilha', 'level' => 2, 'slug' => 'reagentes-eficientes', 'name' => 'Reagentes Eficientes', 'type' => 'passive',
                'description' => 'Tirar 5-6 ao criar recupera 1 Estoque.', 'triggers' => [
                    ['slug' => 'reagentes-eficientes-on-craft', 'name' => 'on_craft', 'condition_type' => 'custom', 'condition_value' => ['note' => '5-6 recupera 1 Estoque'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'frasco-trilha', 'level' => 3, 'slug' => 'mistura-quimica', 'name' => 'Mistura Química', 'type' => 'active',
                'description' => 'Combina 2 frascos em um efeito só.', 'triggers' => [
                    ['slug' => 'mistura-quimica-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],

            // ── Espira ───────────────────────────────────────────────────────
            ['trilha_slug' => 'espira-trilha', 'level' => 1, 'slug' => 'totem-de-alma', 'name' => 'Totem de Alma', 'type' => 'passive',
                'description' => 'Cria um totem que armazena Alma; aliados podem usá-lo com Estamina.', 'triggers' => []],
            ['trilha_slug' => 'espira-trilha', 'level' => 1, 'slug' => 'conjuracao-arcana', 'name' => 'Conjuração Arcana', 'type' => 'passive',
                'description' => 'Seus ataques desarmados passam a ser considerados mágicos.', 'triggers' => []],
            ['trilha_slug' => 'espira-trilha', 'level' => 2, 'slug' => 'energia-espiral', 'name' => 'Energia Espiral', 'type' => 'active',
                'description' => 'Dedica Alma em um teste oposto de Saber.', 'triggers' => [
                    ['slug' => 'energia-espiral-on-opposed-test', 'name' => 'on_opposed_test', 'condition_type' => 'custom', 'condition_value' => ['note' => 'teste de Saber'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'espira-trilha', 'level' => 2, 'slug' => 'extracao-de-alma', 'name' => 'Extração de Alma', 'type' => 'passive',
                'description' => 'Ganha 1 Alma ao causar dano com feitiço.', 'triggers' => [
                    ['slug' => 'extracao-de-alma-on-spell-damage', 'name' => 'on_spell_damage', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'espira-trilha', 'level' => 3, 'slug' => 'emenda-de-feitico', 'name' => 'Emenda de Feitiço', 'type' => 'active',
                'description' => 'Funde duas Arcanas em um único efeito.', 'triggers' => [
                    ['slug' => 'emenda-de-feitico-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],

            // ── Manto ────────────────────────────────────────────────────────
            ['trilha_slug' => 'manto-trilha', 'level' => 1, 'slug' => 'rasante', 'name' => 'Rasante', 'type' => 'active',
                'description' => 'Ação de avanço/pulo gratuita, uma vez por rodada.', 'triggers' => [
                    ['slug' => 'rasante-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'manto-trilha', 'level' => 2, 'slug' => 'celeridade-de-combate', 'name' => 'Celeridade de Combate', 'type' => 'active',
                'description' => 'Dedica Alma como se fosse Estamina em um ataque ou esquiva.', 'triggers' => [
                    ['slug' => 'celeridade-de-combate-on-use', 'name' => 'on_use', 'condition_type' => 'custom', 'condition_value' => ['note' => 'ataque ou esquiva'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'manto-trilha', 'level' => 3, 'slug' => 'coberto-no-vento', 'name' => 'Coberto no Vento', 'type' => 'passive',
                'description' => 'Avanço/pulo não provoca ataques de oportunidade e ganha +1 de distância.', 'triggers' => [
                    ['slug' => 'coberto-no-vento-on-move', 'name' => 'on_move', 'condition_type' => 'custom', 'condition_value' => ['note' => 'avanço/pulo'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'manto-trilha', 'level' => 3, 'slug' => 'velocidade-da-alma', 'name' => 'Velocidade da Alma', 'type' => 'active',
                'description' => 'Usa Alma no lugar de Estamina em um avanço/pulo.', 'triggers' => [
                    ['slug' => 'velocidade-da-alma-on-use', 'name' => 'on_use', 'condition_type' => 'custom', 'condition_value' => ['note' => 'avanço/pulo'], 'target_type' => 'self'],
                ]],

            // ── Sonho ────────────────────────────────────────────────────────
            ['trilha_slug' => 'sonho-trilha', 'level' => 1, 'slug' => 'ferrao-dos-sonhos', 'name' => 'Ferrão dos Sonhos', 'type' => 'passive',
                'description' => 'Manifesta um Ferrão mágico que causa 3 de dano a espíritos.', 'triggers' => []],
            ['trilha_slug' => 'sonho-trilha', 'level' => 1, 'slug' => 'dreno-de-essencia', 'name' => 'Dreno de Essência', 'type' => 'active',
                'description' => 'Drena 1 Alma e 1 Essência ao acertar com o Ferrão dos Sonhos.', 'triggers' => [
                    ['slug' => 'dreno-de-essencia-on-hit', 'name' => 'on_hit', 'condition_type' => 'custom', 'condition_value' => ['note' => 'Ferrão dos Sonhos'], 'target_type' => 'target'],
                ]],
            ['trilha_slug' => 'sonho-trilha', 'level' => 2, 'slug' => 'transferencia', 'name' => 'Transferência', 'type' => 'active',
                'description' => 'Cria um link de roubo de Alma com o alvo.', 'triggers' => [
                    ['slug' => 'transferencia-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'target'],
                ]],
            ['trilha_slug' => 'sonho-trilha', 'level' => 3, 'slug' => 'pitada-de-precognicao', 'name' => 'Pitada de Precognição', 'type' => 'passive',
                'description' => 'Adivinha o número de sucessos antes de atacar, se tiver Essência.', 'triggers' => [
                    ['slug' => 'pitada-de-precognicao-on-before-attack', 'name' => 'on_before_attack', 'condition_type' => 'custom', 'condition_value' => ['note' => 'tem Essência'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'sonho-trilha', 'level' => 3, 'slug' => 'me-aponte-o-caminho', 'name' => 'Me Aponte o Caminho', 'type' => 'active',
                'description' => 'Vislumbra o futuro gastando 5 Essência.', 'activation_cost' => ['essencia' => 5], 'triggers' => [
                    ['slug' => 'me-aponte-o-caminho-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],

            // ── Pesadelo ─────────────────────────────────────────────────────
            ['trilha_slug' => 'pesadelo-trilha', 'level' => 1, 'slug' => 'portador-da-chama', 'name' => 'Portador da Chama', 'type' => 'passive',
                'description' => '+5 Essência máxima e ganha Assustador.', 'triggers' => []],
            ['trilha_slug' => 'pesadelo-trilha', 'level' => 1, 'slug' => 'brasas-acorrentadas', 'name' => 'Brasas Acorrentadas', 'type' => 'passive',
                'description' => 'Ganha 1 Essência quando um adjacente morre.', 'triggers' => [
                    ['slug' => 'brasas-acorrentadas-on-death', 'name' => 'on_death', 'condition_type' => 'custom', 'condition_value' => ['note' => 'adjacente'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'pesadelo-trilha', 'level' => 1, 'slug' => 'transfixo', 'name' => 'Transfixo', 'type' => 'active',
                'description' => 'Gasta 1 Essência para +1 dado ao conjurar um feitiço.', 'activation_cost' => ['essencia' => 1], 'triggers' => [
                    ['slug' => 'transfixo-on-use', 'name' => 'on_use', 'condition_type' => 'custom', 'condition_value' => ['note' => 'conjurar feitiço'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'pesadelo-trilha', 'level' => 2, 'slug' => 'invasao-do-pesadelo', 'name' => 'Invasão do Pesadelo', 'type' => 'active',
                'description' => 'Cria chamas vermelhas em um quadrado (1 dano imediato, 2 por turno).', 'activation_cost' => ['essencia' => 1], 'triggers' => [
                    ['slug' => 'invasao-do-pesadelo-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'area', 'area_shape' => 'explosion', 'area_params' => ['range' => 1]],
                ]],
            ['trilha_slug' => 'pesadelo-trilha', 'level' => 3, 'slug' => 'coracoes-do-pesadelo', 'name' => 'Corações do Pesadelo', 'type' => 'passive',
                'description' => 'Pode ganhar Coração no lugar de Alma ao causar dano.', 'triggers' => [
                    ['slug' => 'coracoes-do-pesadelo-on-damage-dealt', 'name' => 'on_damage_dealt', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],

            // ── Flor ─────────────────────────────────────────────────────────
            ['trilha_slug' => 'flor-trilha', 'level' => 1, 'slug' => 'broto-da-vida', 'name' => 'Broto da Vida', 'type' => 'passive',
                'description' => '+0.5 Fofo; pode cultivar plantas.', 'triggers' => []],
            ['trilha_slug' => 'flor-trilha', 'level' => 1, 'slug' => 'renascimento-de-alma', 'name' => 'Renascimento de Alma', 'type' => 'active',
                'description' => 'Cura um aliado a até 3 quadrados de distância, usando uma ação de Foco.', 'triggers' => [
                    ['slug' => 'renascimento-de-alma-on-focus', 'name' => 'on_focus', 'condition_type' => 'none', 'target_type' => 'allies', 'area_params' => ['range' => 3]],
                ]],
            ['trilha_slug' => 'flor-trilha', 'level' => 2, 'slug' => 'aliado-da-mata', 'name' => 'Aliado da Mata', 'type' => 'passive',
                'description' => 'Pode falar com plantas.', 'triggers' => []],
            ['trilha_slug' => 'flor-trilha', 'level' => 2, 'slug' => 'alma-ressonante', 'name' => 'Alma Ressonante', 'type' => 'passive',
                'description' => '+1 dado por aliado ao curar.', 'triggers' => [
                    ['slug' => 'alma-ressonante-on-focus', 'name' => 'on_focus', 'condition_type' => 'custom', 'condition_value' => ['note' => 'cura'], 'target_type' => 'allies'],
                ]],
            ['trilha_slug' => 'flor-trilha', 'level' => 3, 'slug' => 'desabrochar', 'name' => 'Desabrochar', 'type' => 'passive',
                'description' => 'Todos os dados são sucessos ao curar outros.', 'triggers' => [
                    ['slug' => 'desabrochar-on-focus', 'name' => 'on_focus', 'condition_type' => 'custom', 'condition_value' => ['note' => 'curar outros'], 'target_type' => 'allies'],
                ]],
            ['trilha_slug' => 'flor-trilha', 'level' => 3, 'slug' => 'forca-da-natureza', 'name' => 'Força da Natureza', 'type' => 'passive',
                'description' => 'Recupera Estamina mesmo na Porta da Morte.', 'triggers' => []],

            // ── Espinho ──────────────────────────────────────────────────────
            ['trilha_slug' => 'espinho-trilha', 'level' => 1, 'slug' => 'laminas-envenenadas', 'name' => 'Lâminas Envenenadas', 'type' => 'active',
                'description' => 'Gera Estoque de Glória para preparar venenos.', 'triggers' => [
                    ['slug' => 'laminas-envenenadas-on-use', 'name' => 'on_use', 'condition_type' => 'none', 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'espinho-trilha', 'level' => 1, 'slug' => 'pocao-de-bruxa', 'name' => 'Poção de Bruxa', 'type' => 'passive',
                'description' => '+1 Estoque, +2 receitas de veneno.', 'triggers' => []],
            ['trilha_slug' => 'espinho-trilha', 'level' => 2, 'slug' => 'agonia-ressonante', 'name' => 'Agonia Ressonante', 'type' => 'passive',
                'description' => 'Ganha 1 Alma ao acertar um alvo já envenenado.', 'triggers' => [
                    ['slug' => 'agonia-ressonante-on-hit', 'name' => 'on_hit', 'condition_type' => 'custom', 'condition_value' => ['note' => 'alvo já envenenado'], 'target_type' => 'target'],
                ]],
            ['trilha_slug' => 'espinho-trilha', 'level' => 3, 'slug' => 'componentes-materiais', 'name' => 'Componentes Materiais', 'type' => 'active',
                'description' => 'Usa Estoque no lugar de Alma em um feitiço de Espinho.', 'triggers' => [
                    ['slug' => 'componentes-materiais-on-use', 'name' => 'on_use', 'condition_type' => 'custom', 'condition_value' => ['note' => 'feitiço de Espinho'], 'target_type' => 'self'],
                ]],

            // ── Pó ───────────────────────────────────────────────────────────
            ['trilha_slug' => 'po-trilha', 'level' => 1, 'slug' => 'o-esvaziamento', 'name' => 'O Esvaziamento', 'type' => 'active',
                'description' => 'Transforma um corpo em Seco, como ação de acampamento.', 'triggers' => [
                    ['slug' => 'o-esvaziamento-on-use', 'name' => 'on_use', 'condition_type' => 'custom', 'condition_value' => ['note' => 'ação de acampamento'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'po-trilha', 'level' => 1, 'slug' => 'armada-de-po', 'name' => 'Armada de Pó', 'type' => 'passive',
                'description' => 'Pode controlar Secos.', 'triggers' => []],
            ['trilha_slug' => 'po-trilha', 'level' => 2, 'slug' => 'morte-viva', 'name' => 'Morte Viva', 'type' => 'passive',
                'description' => 'Seus Secos parecem mais naturais.', 'triggers' => []],
            ['trilha_slug' => 'po-trilha', 'level' => 2, 'slug' => 'lealdade', 'name' => 'Lealdade', 'type' => 'passive',
                'description' => 'Ganha 1 Alma quando um Seco seu causa dano.', 'triggers' => [
                    ['slug' => 'lealdade-on-hit', 'name' => 'on_hit', 'condition_type' => 'custom', 'condition_value' => ['note' => 'Seco causou dano'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'po-trilha', 'level' => 3, 'slug' => 'vento-vazio', 'name' => 'Vento Vazio', 'type' => 'active',
                'description' => 'Transforma um corpo em Seco usando uma ação de Foco.', 'triggers' => [
                    ['slug' => 'vento-vazio-on-use', 'name' => 'on_use', 'condition_type' => 'custom', 'condition_value' => ['note' => 'ação de Foco'], 'target_type' => 'self'],
                ]],
            ['trilha_slug' => 'po-trilha', 'level' => 3, 'slug' => 'tumbas-vazias', 'name' => 'Tumbas Vazias', 'type' => 'passive',
                'description' => 'Feitiços de Pó nível 2+ transformam o alvo morto em Seco automaticamente.', 'triggers' => [
                    ['slug' => 'tumbas-vazias-on-kill', 'name' => 'on_kill', 'condition_type' => 'custom', 'condition_value' => ['note' => 'feitiço de Pó 2+'], 'target_type' => 'self'],
                ]],
        ];
    }

    public function run(): void
    {
        foreach (self::definitions() as $def) {
            $trilha = Trilha::where('slug', $def['trilha_slug'])->first();
            if (! $trilha) {
                continue;
            }

            $ability = Ability::updateOrCreate(
                ['slug' => $def['slug']],
                [
                    'name' => $def['name'],
                    'description' => $def['description'],
                    'type' => $def['type'],
                    'activation_cost' => $def['activation_cost'] ?? null,
                    'cooldown' => $def['cooldown'] ?? 0,
                    'is_magic' => $trilha->tipo === 'mistico',
                    'is_unique' => false,
                ]
            );

            $triggerIds = [];
            foreach ($def['triggers'] as $t) {
                $trigger = Trigger::updateOrCreate(
                    ['slug' => $t['slug']],
                    [
                        'name' => $t['name'],
                        'description' => $t['description'] ?? null,
                        'condition_type' => $t['condition_type'],
                        'condition_value' => $t['condition_value'] ?? null,
                        'target_type' => $t['target_type'],
                        'area_shape' => $t['area_shape'] ?? null,
                        'area_params' => $t['area_params'] ?? null,
                    ]
                );
                $triggerIds[] = $trigger->id;
            }
            $ability->triggers()->sync($triggerIds);

            AbilitySource::updateOrCreate([
                'ability_id' => $ability->id,
                'source_type' => Trilha::class,
                'source_id' => $trilha->id,
                'level' => $def['level'],
            ], []);
        }
    }
}
