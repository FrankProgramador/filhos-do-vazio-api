<?php

namespace Database\Seeders;

use App\Models\Trilha;
use Illuminate\Database\Seeder;

class TrilhaSeeder extends Seeder
{
    public function run(): void
    {
        $trilhas = [
            ['slug' => 'ferrao-trilha', 'nome' => 'Ferrão', 'tipo' => 'marcial', 'nivel' => 1, 'beneficios' => 'Quebra-Guarda: 4s contam como sucessos contra oponentes que você já causou dano.', 'barra_aumentada' => 'estamina', 'aumento' => 1],
            ['slug' => 'agulha-trilha', 'nome' => 'Agulha', 'tipo' => 'marcial', 'beneficios' => 'Ataques Rápidos: usa Graça para atacar corpo a corpo (exceto Peso 2+). Estocada Afiada: -1 para +1 alcance.', 'barra_aumentada' => 'estamina', 'aumento' => 1],
            ['slug' => 'presa-trilha', 'nome' => 'Presa', 'tipo' => 'marcial', 'beneficios' => 'Ataque Poderoso: gastando 3+ Estamina, causa +1 de dano (+2 se arma pesada).', 'barra_aumentada' => 'estamina', 'aumento' => 1],
            ['slug' => 'gancho-trilha', 'nome' => 'Gancho', 'tipo' => 'marcial', 'beneficios' => 'Foice Sutil: usa Graça para ataques corpo a corpo. Puxar/Empurrar: -1 dano para mover alvo 1 quadrado. Bolsa de Truques: +1 Estoque e duas receitas de armadilha.', 'barra_aumentada' => 'estamina', 'aumento' => 1],
            ['slug' => 'casca-trilha', 'nome' => 'Casca', 'tipo' => 'marcial', 'beneficios' => 'Golpes de Relance: 4s contam como sucessos ao amortecer após aparar. Olhar Aguçado: primeiro ataque de oportunidade da rodada grátis.', 'barra_aumentada' => 'estamina', 'aumento' => 1],
            ['slug' => 'funda-trilha', 'nome' => 'Funda', 'tipo' => 'marcial', 'beneficios' => 'Bom Braço: usa Poder ao invés de Graça para ataques à distância. Tiro Longo: dobra alcance com -1 por quadrado extra.', 'barra_aumentada' => 'estamina', 'aumento' => 1],
            ['slug' => 'frasco-trilha', 'nome' => 'Frasco', 'tipo' => 'marcial', 'beneficios' => 'Arremesso Fácil: arremessar frascos não custa Estamina. Guerrilha Química: +1 Estoque, 3 receitas de frasco.', 'barra_aumentada' => 'estamina', 'aumento' => 1],
            ['slug' => 'espira-trilha', 'nome' => 'Espira', 'tipo' => 'mistico', 'beneficios' => 'Totem de Alma: pode criar totem que armazena Alma. Conjuração Arcana: focos arcanos são armas enfeitiçadas.', 'barra_aumentada' => 'alma', 'aumento' => 1],
            ['slug' => 'manto-trilha', 'nome' => 'Manto', 'tipo' => 'mistico', 'beneficios' => 'Rasante: ação de pulo/avanço grátis uma vez por rodada. Pode fazer no ar.', 'barra_aumentada' => 'alma', 'aumento' => 1],
            ['slug' => 'sonho-trilha', 'nome' => 'Sonho', 'tipo' => 'mistico', 'beneficios' => 'Ferrão dos Sonhos: arma mágica (dano 3 a espíritos). Dreno de Essência: ganha 1 Alma e 1 Essência ao acertar (uma vez por alvo por descanso). Barra de Essência (5).', 'barra_aumentada' => 'alma', 'aumento' => 1],
            ['slug' => 'pesadelo-trilha', 'nome' => 'Pesadelo', 'tipo' => 'mistico', 'beneficios' => 'Portador da Chama: aura de calor, Essência. Brasas Acorrentadas: ganha Essência ao matar adjacente. Transfixo: pode gastar Essência para +1 em ataque/defesa.', 'barra_aumentada' => 'alma', 'aumento' => 1],
            ['slug' => 'flor-trilha', 'nome' => 'Flor', 'tipo' => 'mistico', 'beneficios' => 'Broto da Vida: +0.5 Fofo, cultiva plantas. Renascimento de Alma: pode curar aliados com Foco.', 'barra_aumentada' => 'alma', 'aumento' => 1],
            ['slug' => 'espinho-trilha', 'nome' => 'Espinho', 'tipo' => 'mistico', 'beneficios' => 'Lâminas Envenenadas: gera Estoque de Glória para venenos. Poção de Bruxa: +1 Estoque, 2 receitas de veneno.', 'barra_aumentada' => 'alma', 'aumento' => 1],
            ['slug' => 'po-trilha', 'nome' => 'Pó', 'tipo' => 'mistico', 'beneficios' => 'O Esvaziamento: ritual para criar Secos. Armada de Pó: controla Secos (até nível em Pó).', 'barra_aumentada' => 'alma', 'aumento' => 1],
        ];

        foreach ($trilhas as $trilha) {
            Trilha::updateOrCreate(['slug' => $trilha['slug']], $trilha);
        }
    }
}
