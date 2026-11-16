# Guia de Implementação WordPress + Arquitetura SEO & GEO
## Concierge de Fim de Ano 2026 — Ghee Banqueteria

---

## 1. Arquivos Gerados no Projeto

1. **`index.html`**
   - Aplicação completa e autocontida em **HTML5 Semântico + CSS3 (Tokens Visuais Ghee) + Vanilla JS (IIFE)** + **Schema JSON-LD (SEO/GEO)**.
   - Contém todos os **44 pratos reais do catálogo de Natal & Réveillon 2026** (com códigos `#01` a `#44`, gramaturas de `500g`/`1kg`, tamanhos `Pequeno`/`Grande`, selos `Sem Glúten`, `Sem Lactose`, `Vegano` e `Vegetariano`), além das **2 Ceias Completas Oficiais da página 43** (`R$ 2.060,00` para 4–6 pessoas e `R$ 5.375,00` para 12–15 pessoas, aplicando automaticamente os **10% de desconto na sobremesa**).
2. **`ghee-concierge-wordpress.php`**
   - Plugin/Snippet leve para WordPress que registra o shortcode `[ghee_concierge_fim_de_ano]` e cria o endpoint nativo `?ghee_bulk_add=ID1:QTD1,ID2:QTD2` para adicionar múltiplos produtos da ceia ao carrinho do WooCommerce de uma só vez.

---

## 2. Como Incorporar no WordPress (`ghee.com.br`)

### Opção A — Via Bloco HTML Personalizado (Gutenberg ou Elementor)
1. Abra a página de **Natal & Réveillon** no editor do WordPress.
2. Adicione um bloco **HTML Personalizado** (Custom HTML).
3. Copie do arquivo `index.html`:
   - A tag `<script type="application/ld+json">...</script>` (Dados estruturados SEO/GEO)
   - A tag `<style>...</style>`
   - O bloco `<main id="ghee-concierge-natal-reveillon">...</main>` e o `<script>...</script>` logo abaixo dele.
4. Salve e publique. Todo o CSS está escopado na classe `.ghee-concierge-root` para não afetar o cabeçalho ou rodapé do tema atual.

### Opção B — Via Shortcode `[ghee_concierge_fim_de_ano]` (Mais seguro contra filtros do editor)
1. Compacte a pasta com `index.html` e `ghee-concierge-wordpress.php` em um `.zip` e envie em **Plugins → Adicionar Novo → Enviar Plugin** (ou cole a função no plugin *WPCode / Code Snippets*).
2. Na página desejada, insira apenas o shortcode:
   ```text
   [ghee_concierge_fim_de_ano]
   ```

---

## 3. Como Conectar os IDs dos Produtos no WooCommerce

No arquivo `index.html`, dentro da constante `CATALOG`, cada prato possui a propriedade `wcProductId: 0`:

```javascript
{
  id: 'item-15', code: '15', category: 'principais',
  name: 'Peru clássico de Natal recheado com farofa natalina',
  price: 2200, servesPeople: 14, weightGrams: 8000,
  wcProductId: 4821 // <-- Coloque aqui o ID do produto ou variação no WooCommerce
}
```

- **Onde achar o ID no WordPress:** Vá em **Produtos → Todos os Produtos** no painel do WordPress e passe o mouse sobre o prato (o ID aparece em `ID: XXXX`). Se o prato tiver variação (`500g` vs `1kg` ou `Pequena` vs `Grande`), use o **ID da variação** correspondente.
- **Comportamento inteligente:** Enquanto `wcProductId` estiver como `0`, o botão encaminha o cliente diretamente para o WhatsApp oficial `(11) 99925-7045` com toda a lista codificada (`#01` a `#44`), quantidades, data de entrega/retirada e modalidade de pagamento já calculadas.

---

## 4. Otimizações Avançadas de SEO e GEO Implementadas

Para garantir que a página da Ghee ranqueie no Google tradicional (**SEO**) e seja citada como resposta principal em motores de busca generativos (**GEO**: *Google AI Overviews, ChatGPT Search, Perplexity, Gemini e Claude*):

1. **Grafo Semântico `@graph` em JSON-LD (`Schema.org`):**
   - `FoodEstablishment` + `Catering`: Conecta a entidade **Ghee Banqueteria**, seus fundadores (**Chef Paulo Neves** e **Oghan Teixeira**), endereço na **Aclimação (São Paulo - SP)**, área de cobertura (**SP Capital, Interior e Litoral**) e canal de vendas.
   - `Menu` + `MenuSection` + `MenuItem`: Expõe preços oficiais em `BRL`, validade sazonal (`2026-12-26`) e dietas restritivas padronizadas (`GlutenFreeDiet`, `LowLactoseDiet`).
   - `WebApplication`: Identifica a calculadora interativa para o Google como uma ferramenta utilitária de planejamento de ceia (`AggregateOffer` de `R$ 120,00` a `R$ 5.375,00`).
   - `FAQPage`: Responde diretamente às perguntas de alta intenção de compra (*"Quanto calcular de comida por pessoa na Ceia de Natal?"*, *"Qual o valor de uma Ceia de Natal pronta da Ghee Banqueteria?"*, *"Até que dia posso encomendar?"*).
2. **Tabela Técnica HTML de Consumo Per Capita (Citabilidade em LLMs):**
   - Motores de IA generativa priorizam páginas que apresentam dados tabulares claros (`<table>` com gramaturas por adulto para entradas, proteínas, acompanhamentos e sobremesas) em HTML estático, sem depender de execução de JavaScript para leitura pelos crawlers (`GPTBot`, `Google-Extended`, `PerplexityBot`).
3. **Zero Dependências Externas & Core Web Vitals:**
   - Código em Vanilla JS puro (0 KB de bibliotecas externas), transições aceleradas por GPU e layout sem deslocamento cumulativo (`CLS = 0`).
