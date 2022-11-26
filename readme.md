# PHP ngram language detection

PHP library that detects the language from a text string.

## Features

- More than 350 supported languages
- Very fast, no database needed
- Packaged with a 500kb dataset
- Learning steps are already done, library is ready to use
- Small code, small footprint
- N-grams algorithm
- Supports PHP 8.0

## Install

```bash
composer require one23/language-detection
```

---

## Quick usage

```php
$texts = [
  // rus
  'В тексте декларации содержалось подтверждение позиции сторон, что «полная победа над общим врагом является необходимым условием для защиты жизни, свободы, независимости и права на свободу религии, а также для торжества прав человека и справедливости как на родной земле, так и на других территориях, и что стороны в настоящее время втянуты в общую борьбу против варварски жестоких сил, которые хотят покорить весь мир». Принцип «полной победы» впервые обозначил политику союзников, направленную на «безоговорочную капитуляцию» стран Оси. Основной целью сторон ставилось поражение «гитлеризма», что означало согласие сторон с тождественностью тоталитарных милитаристских режимов в Германии, Италии и Японии.',
  // arb
  'بحلول نهاية الحرب، انضمت 21 دولة أخرى إلى الإعلان، بما في ذلك الفلبين (دولة غير مستقلة، كومنولث أمريكي في ذلك الوقت)، وفرنسا، وكل دولة في أمريكا اللاتينية باستثناء الأرجنتين،  ومختلف الدول المستقلة في الشرق الأوسط وأفريقيا. على الرغم من أن معظم قوى المحور الصغيرة قد غيرت مواقفها وانضمت إلى الأمم المتحدة كأطراف متحاربة ضد ألمانيا بحلول نهاية الحرب، لم يُسمح لهم بالانضمام إلى الإعلان. لم توقع الدنمارك المحتلة على الإعلان، ولكن بسبب المقاومة الشديدة بعد عام 1943، ولأن السفير الدنماركي هنريك كوفمان قد أعرب عن التزامه بإعلان جميع الدنماركيين الأحرار، فقد تمت دعوة الدنمارك مع ذلك من بين الحلفاء في مؤتمر سان فرانسيسكو في مارس 1945.',
  // azj
  'Tərəflər Atlantik Nizamnaməsini həyata keçirmək, bütün resurslarını Berlin-Roma-Tokio oxu ölkələri ilə müharibə üçün istifadə etmək, həmçinin Almaniya və ya Yaponiya ilə ayrı-ayrılıqda sülhün yaradılmasına razılıq vermədi. Müharibənin sonunda bir çox başqa ölkələr Filippin, Fransa, Argentinadan başqa bütün Latın Amerikası ölkələri , Yaxın Şərq və Afrikanın bəzi müstəqil dövlətləri də daxil olmaqla bəyannaməyə qoşulmuşdur. Berlin-Roma-Tokio oxu ölkələrinin əksəriyyəti sonradan Birləşmiş Millətlər Təşkilatının tərəfinə keçərək Almaniyaya qarşı döyüşsələr də, bəyannaməyə qoşulmaq üçün icazə verilməmişdir.',
  // eng
  "The Declaration by United Nations was drafted at the White House on December 29, 1941, by US President Franklin D. Roosevelt, British Prime Minister Winston Churchill, and the Roosevelt aide Harry Hopkins. It incorporated Soviet suggestions but left no role for France. Roosevelt first coined the term \"United Nations\" to describe the Allied countries. Roosevelt suggested \"United Nations\" as an alternative to the name \"Associated Powers\" (the U.S. was never formally a member of the Allies of World War I but entered the war in 1917 as a self-styled \"Associated Power\"). Churchill accepted it and noted that the phrase was used by Lord Byron in the poem Childe Harold's Pilgrimage (Stanza 35). The term was first officially used on 1–2 January 1942, when 26 governments signed the declaration. One major change from the Atlantic Charter was the addition of a provision for religious freedom, which Stalin approved after Roosevelt insisted. The Declaration by United Nations was the basis of the modern United Nations.",
  // spa
  'Antes de la declaración, el gobierno de Estados Unidos presionaba a todos los países que no tenían participación directa en el conflicto a involucrarse en la lucha contra los países del Eje, refiriéndose a esos países como países comprometidos con las "Naciones Unidas" (es decir los Aliados) en la guerra mundial. El compromiso, que era prácticamente simbólico, era forzado mediante las cuotas en las importaciones de materias primas y la ayuda económica y militar que recibían.',
  // fra
  "Wikipédia est un projet d’encyclopédie collective en ligne, universelle, multilingue et fonctionnant sur le principe du wiki. Ce projet vise à offrir un contenu librement réutilisable, objectif et vérifiable, que chacun peut modifier et améliorer. Wikipédia est définie par des principes fondateurs. Son contenu est sous licence Creative Commons BY-SA. Il peut être copié et réutilisé sous la même licence, sous réserve d'en respecter les conditions. Wikipédia fournit tous ses contenus gratuitement, sans publicité, et sans recourir à l'exploitation des données personnelles de ses utilisateurs.",
  // tat
  'Википедия коммерцияға ҡарамаған «Викимедиа фонды» ойошмаһыныҡы. Фондтың 39 төбәк бүлексәһе бар. Уның маҡсаты — күп телле энциклопедия төҙөү. Башҡорт телендәге Википедия — күп телле проекттың бер өлөшө. Энциклопедияның исеме ике өлөштән тора. Беренсеһе инглиз телендәге wiki «вики» һүҙенән, был һүҙ сайт төҙөлгән технологияны аңлата; үҙ сиратында был һүҙ гавай телендә «тиҙ, етеҙ» тигәнде аңлата. Икенсе өлөшө encyclopedia «энциклопедия» һүҙенән алынған.',
  // deu
  'Hugo Princz (geboren am 22. November 1922 in Slivník, Tschechoslowakei; gestorben am 29. Juli 2001 in Highland Park, New Jersey) war als amerikanischer Staatsbürger jüdischer Herkunft ab 1942 unter anderem in Auschwitz der nationalsozialistischen Gewalt ausgeliefert und musste Zwangsarbeit leisten. In Poing wurde er im April 1945 Zeuge des Massakers an Mithäftlingen, bevor er am 1. Mai 1945 von amerikanischen Soldaten befreit wurde. Er überlebte den Holocaust und erlangte nach und nach Gewissheit, dass von seinen Familienangehörigen niemand den Holocaust überlebt hatte. 1946 siedelte er in die USA um. Nach einer Tätigkeit als Fleischer in einem Supermarkt kaufte und leitete er diesen. Er kämpfte jahrzehntelang für eine Entschädigung, die deutsche Stellen stets ablehnten. Erst 1995, als seine Klagen gegen Deutschland und deutsche Großunternehmen in der amerikanischen Politik Rückhalt fanden, ließen sich Deutschland und die beklagten Unternehmen auf eine Zahlung ein',
  // slk
  'Punk rock alebo punk je žáner rockovej hudby, ktorý sa vyvinul v polovici 70. rokov 20. storočia. Korene má v garážovom rocku a iných hudobných formách dnes známych pod názvom protopunk. Punkrockové skupiny sa vyhýbali tomu, čo chápali ako výstrelky komerčného rocku 70. rokov 20. storočia; vytvorili rýchlu, náročnú hudbu, obyčajne s krátkymi piesňami, jednoduchou inštrumentáciou a nezriedka s politickými textami vystupujúcimi proti establishmentu. Punk rock si osvojil prístup DIY (Do it Yourself – Urob si sám); mnohé kapely si samy produkujú nahrávky a distribuujú ich pomocou neformálnych ciest.',
  // ron
  'În anul 2005 a decis să urmeze o carieră solo, colaborând cu mai mulți muzicieni ai genului de muzică electronic dance. În 2009 și-a lansat albumul de debut, Embers. Criticii au apreciat-o pentru originalitatea versurilor, combinate cu muzică electronică, baladă, orientală și acustică. Trei dintre melodiile de pe album au ajuns în top 10 Billboard Hot Dance Club Play, printre care și hitul „Love Story”, care a atins primul loc. Cântecul a fost de asemenea nominalizat la cea de-a 25-a ediție a Premiilor Internaționale pentru Muzică Dance la WMC, în timp ce „Fantasy” a fost nominalizat la premiile Grammy.',
  // tur
  "İmroz Deniz Muharebesi, I. Dünya Savaşı sırasında, 20 Ocak 1918'de Ege Denizi'nde gerçekleşen bir deniz muharebesidir. Osmanlı donanmasının Gökçeada'da yığınak yapmış olan Kraliyet Donanması'na taarruzu ile meydana gelmişti. İtilaf kuvvetlerinin ağır zırhlı yoksunluğu, Yavuz muharebe kruvazörü ile Midilli hafif kruvazörünün bölgeye taarruz etmesine fırsat sağlamıştı. Saldırı sonucunda Birleşik Krallık'a ait monitör olarak sınıflandırılan iki küçük savaş gemisi battı, bir uçak düşürüldü ve birçok personel öldü. Muharebe sırasında önemli hasar almayan Osmanlı gemileri, dönüş esnasında adayı saldırılardan korumak üzere İtilaf güçlerince döşenmiş olan deniz mayınlarına çarptı. Yavuz hasar aldı, Midilli ise battı ve mürettebatının bir kısmı öldü, bir kısmı ise esir düştü. Yavuz, Birleşik Krallık uçaklarının saldırıları altında Çanakkale Boğazı'na ulaşmayı başardı; buraya vardığında karaya oturdu ve altı gün sonra kurtarılana dek sürekli hava saldırısına maruz kaldı.",
  // ukr
  'Опера́ція «Зі́льберфукс» (нім. Unternehmen Silberfuchs, операція «Чорнобурка») — спільна наступальна операція німецьких та фінських військ у Лапландії, на північному фланзі німецько-радянської війни. Тривала з 29 червня до 17 листопада 1941 року. Метою було захоплення Мурманська — стратегічно важливого радянського морського порту. Операцію «Зільберфукс» планувалося провести у два етапи. На першому етапі в ході операції «Реннтір» німецькі гірські війська, що виділялися для проведення наступальної операції на Мурманськ, з території окупованої Норвегії мали захопити під свій контроль регіон Петсамо з його нікелевими шахтами. На другому етапі німецько-фінські війська за задумом мали завдати одночасно удари з двох напрямків: в операції «Платинфукс» на північному фланзі планувався наступ німецького гірського корпусу «Норвегія» безпосередньо на Мурманськ, а на південному фланзі за задумом операції «Полярфукс» силами німецького 36-го командування особливого призначення у взаємодії з частинами 3-го фінського корпусу планувалось захоплення міста Кандалакша з подальшим виходом на узбережжя Білого моря.',
  // ydd
  'קאמוניזם, טייטש: א טעאריע און סיסטעם פון סאציאלע און פאליטישע ארגאניזאציע וועלכע איז געווען א הויפט קראפט אין וועלטליכע פאליטיק פאר רוב יארן אינעם 20סטן יאר-הונדערט. אלס א פאליטישע באוועגונג האט קאמוניזם געזוכט אונטערצואווארפן קאפיטאליזם דורך אן ארבייטערס רעוואלוציע און איינשטעלן א סיסטעם אין וועלכע פראפערטי איז די אייגנשאפט פון א גאנצע באפעלקערונג אינאיינעם אנשטאט אינדיווידועלן.',
  // cmn
  '《试播集》是美国电视连续剧《邪恶力量》的第一集，于2005年9月13日在WB电视网首播，剧集主创人埃里克·克莱普克编剧，大卫·努特尔执导。这一试播首次向观众引荐了萨姆·威彻斯特和迪恩·威彻斯特兄弟，两人在全美各地猎杀超自然物种，联手对抗一个幽灵般的白衣女子，还要在这一过程中寻找他们失踪的父亲。《试播集》是在洛杉矶制作，不过之后的剧集为了节省资金而转移到了加拿大不列颠哥伦比亚的温哥华取景。本集还开创了节目使用摇滚乐作为配乐的传统，其中包含有克莱普克的朋友克里斯托弗·莱纳兹创作的音乐。本剧所获评价褒贬不一，多位评论家称赞了其中的恐怖元素，但对几位主要演员的表演有着多种不同意见。',
  // jpn
  '赤血球は血液細胞の一つで色は赤く血液循環によって体中を回り、肺から得た酸素を取り込み、体のすみずみの細胞に運び供給する役割を担い、また二酸化炭素の排出にも関わる。赤血球の内部には鉄を含むタンパク質ヘモグロビンが充満しており、赤血球はヘモグロビンに酸素を取り込む。大きさは直径が7-8μm、厚さが2μm強ほどの両面中央が凹んだ円盤状であり、数は血液1μLあたり成人男性で450-650万個、成人女性で380-580万個程度で血液の容積のおよそ4-5割程度が赤血球の容積である',
  // kor
  '행성상성운(行星狀星雲, planetary nebula)은 발광성운의 일종으로, 늙은 적색거성의 외피층이 팽창하여 형성된 전리 기체들로 이루어져 있다. 이 용어는 1780년대에 윌리엄 허셜이 고안한 것으로, 망원경으로 들여다보았을 때 행성처럼 원반 모양의 상을 나타낸다고 하여 만들어진 용어인즉, 엄밀히는 틀린 용어이다. 하지만 허셜의 용어는 널리 사용되었고, 지금까지 그대로 사용되고 있다. 행성상성운의 수명은 수만 년 정도로, 우주적 규모에서는 상대적으로 짧게 지속되는 현상이다.',
  // hi
  'ग्लेशियर नेशनल पार्क अमेरिकी राष्ट्रीय उद्यान है, जो कि कनाडा-संयुक्त राज्य अमेरिका की सीमा पर स्थित है। उद्यान संयुक्त राज्य के उत्तर-पश्चिमी मोंटाना राज्य में स्थित है और कनाडा की ओर अल्बर्टा और ब्रिटिश कोलम्बिया प्रांतों से सटा हुआ है। उद्यान दस लाख एकड़ (4,000 किमी2) से अधिक क्षेत्र में फैला हुआ है और इसमें दो पर्वत श्रृंखला (रॉकी पर्वत की उप-श्रेणियाँ), 130 से अधिक नामित झीलें, 1,000 से अधिक विभिन्न पौधों की प्रजातियां और सैकड़ों वन्यजीवों की प्रजातियां शामिल हैं। इस विशाल प्राचीन पारिस्थितिकी तंत्र को जो कि 16,000 वर्ग मील (41,000 किमी2) में शामिल संरक्षित भूमि का भाग है, "क्राउन ऑफ़ द कॉन्टिनेंट इकोसिस्टम" के रूप में संदर्भित किया गया है। विस्तार में जीवाणु एक एककोशिकीय जीव है । इसका आकार कुछ मिलिमीटर तक ही होता है। इनकी आकृति गोल या मुक्त-चक्राकार से लेकर छङा, आदि आकार की हो सकती है। ये प्रोकैरियोटिक कोशिका भित्तियुक्त, एककोशकीय सरल जीव हैं जो प्रायः सर्वत्र पाये जाते है। ये पृथ्वी पर मिट्टी में, अम्लीय गर्म जल-धाराओं में, नाभिकीय पदार्थों में, जल में,भू-पपड़ी में, यहां तक की कार्बनिक पदार्थों में तथा पौधौं एवं जन्तुओं के शरीर के भीतर भी पाये जाते हैं। साधारणतः एक ग्राम मिट्टी में ४ करोड़ जीवाणु कोष तथा १ मिलीलीटर जल में १० लाख जीवाणु पाएं जाते हैं। संपूर्ण पृथ्वी पर अनुमानतः लगभग ५X१०३० जीवाणु पाएं जाते हैं। जो संसार के बायोमास का एक बहुत बड़ा भाग है। ये कई तत्वों के चक्र में बहुत महत्वपूर्ण भूमिका अदा करते हैं, जैसे कि वायुमंडलिए नाइट्रोजन के स्थीरीकरण में। हलाकि बहुत सारे वंश के जीवाणुओं का श्रेणी विभाजन भी नहीं हुआ है तथापि लगभग आधे जातियों को किसी न किसी प्रयोगशाला में उगाया जा चुका है। जीवाणुओं का अध्ययन बैक्टिरियोलोजी के अन्तर्गत किया जाता है जो कि सूक्ष्मजैविकी की ही एक शाखा है।विस्तार से पढ़ें',
  // pes
  'آشنایی با دانشنامهآشنایی با اصول ویرایشکارهای قابل انجامسیاست‌ها و رهنمودهافهرست الفبایی مقاله‌ها مقالهٔ برگزیده تیم ملی فوتبال زنان آلمان نمایندهٔ زنان کشور آلمان در ردهٔ ملی است. این تیم زیر نظر فدراسیون فوتبال آلمان قرار دارد و پیش‌تر با نام آلمان غربی شناخته می‌شد. این تیم نخستین بازی بین‌المللی خود را در سال ۱۹۸۲ انجام داد. پس از اتحاد دو آلمان در سال ۱۹۹۰، اعضای این تیم به عنوان «تیم ملی جمهوری فدرال آلمان» باقی ماند. تیم فوتبال زنان آلمان یکی از موفق‌ترین تیم‌های فوتبال زنان به‌شمار می‌آید. این تیم دارای دو قهرمانی جهان در سال‌های ۲۰۰۳ و ۲۰۰۷ است. آلمان تنها کشوری است که در هر دو ردهٔ مردان و زنان قهرمان جهان شده‌است. تیم آلمان در هشت دوره از یازده دورهٔ مسابقات فوتبال زنان اروپا از جمله شش دورهٔ پیاپی اخیر این رقابت‌ها قهرمان شده‌است. همچنین آلمان تنها کشوری است که در هر دو ردهٔ مردان و زنان در جام ملت‌های اروپا به مقام قهرمانی رسیده‌است. تیم فوتبال زنان آلمان دارای سه مدال برنز و یک طلا در المپیک است که به ترتیب در سال‌های ۲۰۰۰، ۲۰۰۴، ۲۰۰۸ و ۲۰۱۶ بدست آمده‌اند. بیرگیت پرینتس رکورد بیشترین حضور و بیشترین گل زده در این تیم را در اختیار دارد. وی همچنین سه بار برندهٔ جایزهٔ بازیکن سال فوتبال جهان شده ',
];

foreach ($texts as $text) {
  $detector = LanguageDetection\Detector::detect($text, [
      'minLength' => 1,
      'maxLength' => 2048,
      'maxDifference' => 300,
      'only'  => null, // []
      'dict'  => 'default', //
  ]);
  
  $detector->getLanguage();
} // => rus, arb, azj, eng, spa, fra, tat, deu, slk, ron, tur, ukr, ydd, cmn, jpn, kor, mag, pes

//

LanguageDetection\Detector::detect("The Declaration by United Nations was drafted at the White House on December 29, 1941, by US President Franklin D. Roosevelt, British Prime Minister Winston Churchill, and the Roosevelt aide Harry Hopkins. It incorporated Soviet suggestions but left no role for France. Roosevelt first coined the term \"United Nations\" to describe the Allied countries. Roosevelt suggested \"United Nations\" as an alternative to the name \"Associated Powers\" (the U.S. was never formally a member of the Allies of World War I but entered the war in 1917 as a self-styled \"Associated Power\"). Churchill accepted it and noted that the phrase was used by Lord Byron in the poem Childe Harold's Pilgrimage (Stanza 35). The term was first officially used on 1–2 January 1942, when 26 governments signed the declaration. One major change from the Atlantic Charter was the addition of a provision for religious freedom, which Stalin approved after Roosevelt insisted. The Declaration by United Nations was the basis of the modern United Nations.")
    ->getLanguages();
// => ["eng","sco","fra","dan","deu","src","cat",...]

LanguageDetection\Detector::detect("The Declaration by United Nations was drafted at the White House on December 29, 1941, by US President Franklin D. Roosevelt, British Prime Minister Winston Churchill, and the Roosevelt aide Harry Hopkins. It incorporated Soviet suggestions but left no role for France. Roosevelt first coined the term \"United Nations\" to describe the Allied countries. Roosevelt suggested \"United Nations\" as an alternative to the name \"Associated Powers\" (the U.S. was never formally a member of the Allies of World War I but entered the war in 1917 as a self-styled \"Associated Power\"). Churchill accepted it and noted that the phrase was used by Lord Byron in the poem Childe Harold's Pilgrimage (Stanza 35). The term was first officially used on 1–2 January 1942, when 26 governments signed the declaration. One major change from the Atlantic Charter was the addition of a provision for religious freedom, which Stalin approved after Roosevelt insisted. The Declaration by United Nations was the basis of the modern United Nations.")
    ->getLanguage();
// => "eng"

LanguageDetection\Detector::detect("The Declaration by United Nations was drafted at the White House on December 29, 1941, by US President Franklin D. Roosevelt, British Prime Minister Winston Churchill, and the Roosevelt aide Harry Hopkins. It incorporated Soviet suggestions but left no role for France. Roosevelt first coined the term \"United Nations\" to describe the Allied countries. Roosevelt suggested \"United Nations\" as an alternative to the name \"Associated Powers\" (the U.S. was never formally a member of the Allies of World War I but entered the war in 1917 as a self-styled \"Associated Power\"). Churchill accepted it and noted that the phrase was used by Lord Byron in the poem Childe Harold's Pilgrimage (Stanza 35). The term was first officially used on 1–2 January 1942, when 26 governments signed the declaration. One major change from the Atlantic Charter was the addition of a provision for religious freedom, which Stalin approved after Roosevelt insisted. The Declaration by United Nations was the basis of the modern United Nations.")
    ->getScores();
// => [["eng",1],["sco",0.9856188981119092],["fra",0.9534697432368501],["dan",0.9519214227345061],["deu",0.9473302223560277],...]
```

## API Methods

### __constructor(array $options)

```php
$detector = new One23\LanguageDetection\Detector([
  // default options
  'minLength'     => 16,
  'maxLength'     => 2048,
  'maxDifference' => 300,
  'only'          => null,      // ['eng', 'rus', 'fra', ...]
  'dict'          => 'default', // 'min', 'default', 'all'
]);
```

### evaluate(string $str): self

It performs an evaluation on a given text.

```php
$detector->evaluate('Hello world');
```

### getLanguage(): string

The detected language

```php
$detector->getLanguage(); // => 'eng'
```

### getLanguages(): string[]

A list of loaded models that will be evaluated.

```php
$detector->getLanguages(); // => ['deu', 'eng', 'fra', ...]
```

### getScores(): array

A list of loaded models that will be evaluated.

```php
$detector->getScores(); // => [["eng",1], ["sco",0.9856188981119092], ...]
```

### getSupportedLanguages(): string[]

A list of supported languages that will be evaluated.

```php
$detector->getSupportedLanguages(); // => ["ace","ada","afr","als",...]
```

### setDictionary(string $dict): self

```php
$detector->setDictionary('min'); // 'min', 'default', 'all'
```

### setOnly(array $lang): self

```php
$detector->setOnly(['eng', 'rus', 'fra', ]);
```

### getOnly(array $lang): ?array

Get limited languages by supported languages

```php
$detector->getOnly(); // => ["eng","fra","rus",...]
```

### getText(): string

Returns the last string which has been evaluated

```php
$detector->getText(); // => "Hello world"
```

### For one-liners only

```php
LanguageDetection\Detector::detect("Hello world")
    ->getLanguages(); // => 'eng'
```

## Detector639 is extends Detector

### getScores(): array

A list of loaded models that will be evaluated.

```php
$detector->getScores(); // => [["eng",1,Code3Min], ["sco",0.9856188981119092,Code3Min], ...]
```

### getSupportedLanguages(): string[]

A list of supported iso-639-1 languages that will be evaluated.

```php
$detector->getSupportedLanguages(); // => ["afr","amh","hye","bam",...]
```

### getLanguages(): Code3Min[]

A list of loaded models that will be evaluated.

```php
$detector->getLanguages(); // => [Code3Min, Code3Min, Code3Min, ...]
```

### code1(): Code1

```php
$detector->code1(); // => Code1
```

### code2t(): Code2t

```php
$detector->code2t(); // => Code2b
```

### code2b(): Code2b

```php
$detector->code2b(); // => Code2b
```

### code3(): Code3Min

```php
$detector->code3(); // => Code3Min
```

## Use

```php
$detect = LanguageDetection\Detector639::detect(<<<EOF
Crowds gathered for a rally in the city of Rawalpindi, taking flags and signs.
EOF

(string)$detect->code1(); // => 'en'
$detect->code2b(); // => Code2b
$detect->code2t(); // => Code2t
$detect->code3(); // => Code3

```

---

## Additionals

## Ngram

### What's this?

This package gets you bigrams, trigrams, all the [n-grams](https://en.wikipedia.org/wiki/N-gram)!

### Use

```php
use \One23\LanguageDetection\Ngram;

Ngram::biGram("hello");     // => ['he', 'el', 'll', 'lo'];
Ngram::nGram("hello", 2);   // => ['he', 'el', 'll', 'lo'];

Ngram::triBram("hello");    // => ['hel', 'ell', 'llo'];
Ngram::nGram("hello", 3);   // => ['hel', 'ell', 'llo'];

Ngram::nGram("hello", 4);   // => ['hell', 'ello'];
Ngram::nGram("hello", 5);   // => ['hello'];
Ngram::nGram("hello", 6);   // => [];
```

---

## Utils\Trigram

### Use

```php
use \One23\LanguageDetection\Utils\Trigram;

Trigram::clean(" hello@world ");        // => hello world
Trigram::trigrams(" hello@world ");     // => [" he","hel","ell","llo","lo ","o w"," wo","wor","orl","rld","ld "]
Trigram::asDictionary(" hello@hello "); // => {" he":2,"hel":2,"ell":2,"llo":2,"lo ":2,"o h":1}

$tuples = Trigram::asTuples(" world@world "); 
// => [["d w",1],[" wo",2],["wor",2],["orl",2],["rld",2],["ld ",2]]

Trigram::tuplesAsDictionary($tuples);   // => {"d w":1," wo":2,"wor":2,"orl":2,"rld":2,"ld ":2}

```

---

## Utils\WhitespaceCollapse

### Use

```php
use \One23\LanguageDetection\Utils\WhitespaceCollapse;

$str = " Hello\tworld!" .
    "\n" .
    "Hello  world!" .
    "\n" .
    "Hello \t world! " .
    "\n" .
    " \t " .
    "\n" .
    "\n" .
    " Hello \t world! " .
    "\n";

WhitespaceCollapse::collapse($str, []); // " Hello world! Hello world! Hello world! Hello world! "
WhitespaceCollapse::collapse($str, ['trim' => true, ]); // "Hello world! Hello world! Hello world! Hello world!"
WhitespaceCollapse::collapse($str, ['trim' => true, 'pattern' => 'html', ]); // "Hello world! Hello world! Hello world! Hello world!"

WhitespaceCollapse::collapse($str, ['trim' => true, 'pattern' => 'html', 'lineEnd' => true, ]);
/** =>
Hello world!
Hello world!
Hello
world!
Hello world!
**/
```

---

## Security

If you discover any security related issues, please email eugene@krivoruchko.info instead of using the issue tracker.


## License

[MIT](https://github.com/FlexIDK/language-detection/LICENSE)
