
# Walkthrough: Den Försvunna Praktikanten CTF

Följ med på en digital utredning! I den här walkthrough-en bryter jag ner CTF-utmaningen "Den Försvunna Praktikanten". Målet var att hjälpa tech-företaget Innovatech Solutions att hitta sin försvunna praktikant, Alex, genom att följa en kedja av digitala ledtrådar. Utmaningen sträckte sig över webb-hacking, krypto, steganografi, forensik och OSINT.

---

### Del 1 – Nyckeln till portalen (Web Exploitation)

**Uppdraget:** Vår första uppgift var att ta oss förbi inloggningsportalen till företagets interna system.

**Min tankeprocess:** När jag ställs inför en inloggningssida är mitt första steg alltid att leta efter "lågt hängande frukt". Innan man testar komplexa attacker är det värt att kolla det mest grundläggande: Har utvecklarna glömt kvar något? Att granska sidans källkod (`Ctrl+U`) är en självklarhet.

**Lösning:**
Bingo! Inbäddad i HTML-koden fanns en minst sagt avslöjande kommentar:

```html
<!-- Kom ihåg att ta bort testanvändaren 'admin' med det enkla lösenordet 'password123' innan lansering. -->
```

Med dessa uppgifter var det bara att logga in. Väl inne möttes vi av den första flaggan.

> **🚩 Flagg 1:** `CTF{välkommen_till_systemet}`

**Key Takeaway:** Detta är en klassiker. Utvecklarkommentarer, testdata och standardlösenord är en guldgruva vid initial rekognosering. En grundlig kodsanering innan produktion är ett måste.

---

### Del 2 – Det hemliga meddelandet (Kryptografi)

**Uppdraget:** Väl inne i portalen hittade vi en textfil med ett kryptiskt meddelande från Alex.

**Min tankeprocess:** Meddelandet var rena rappakaljan: `GVYY QR ZNEXANQFYRQNAQR...`. Men två ledtrådar stack ut:
1.  *"Caesar den 13:e hade älskat det här."* – En solklar passning till Caesar-chiffer med 13 stegs förskjutning (ROT13).
2.  *"Inte allt syns vid första anblick."* – Detta fick mig direkt att misstänka att det fanns mer information dold på sidan, kanske som vit text på vit bakgrund.

**Lösning:**
Jag kopierade den krypterade texten till CyberChef och applicerade ROT13. Resultatet blev:

> `TILL DE MARKNADSLEDANDE, DE TRENDANDE LÖSENORDEN ÄR INDELADE I TVÅ DELAR.`

Detta bekräftade att vi letade efter ett tvådelat lösenord. För att hitta flaggan följde jag den andra ledtråden och markerade hela sidan (`Ctrl+A`), vilket avslöjade en dold textrad längst ner.

> **🚩 Flagg 2:** `CTF{caesar_är_för_enkel}`

**Key Takeaway:** Obfuskering är inte kryptering. ROT13 är bra för att dölja spoilers, men erbjuder noll säkerhet. Lärdomen är att alltid leta efter flera lager av information.

---

### Del 3 – Bilden som talar (Steganografi)

**Uppdraget:** En teambild (`team.jpg`) fanns också i portalen. Ledtråden från förra steget antydde att lösenordet var uppdelat, så bilden var en het kandidat för den andra halvan.

**Min tankeprocess:** Att gömma data i bilder, steganografi, är ett vanligt inslag i CTF:er. Med tanke på den tidigare ledtråden var det logiskt att bilden innehöll den saknade pusselbiten.

**Lösning:**
Jag laddade ner bilden och analyserade den med ett online-verktyg (https://stylesuxx.github.io/steganography/ fungerar utmärkt för detta). Verktyget extraherade en dold text från bilddatan som innehöll den andra delen av lösenordet:

> `...är_hemligheten`

I samma dolda text fanns även nästa flagga.

> **🚩 Flagg 3:** `CTF{bilden_döljer_mer_än_du_tror}`

**Key Takeaway:** Filer är sällan bara vad de utger sig för att vara. En bild kan innehålla text, en ljudfil kan innehålla ett spektrum och metadata kan avslöja allt från kameramodell till geografisk plats.

---

### Del 4 – Det raderade beviset (Digital Forensik)

**Uppdraget:** Den sista filen i portalen var `alex_usb.img`, en avbild av ett USB-minne. Vid en första anblick verkade den helt tom.

**Min tankeprocess:** En tom diskavbild i en CTF är aldrig tom. Det skriker "filåterställning". När filer "raderas" från ett filsystem tas oftast bara pekaren till datan bort, medan själva datan ligger kvar tills den skrivs över.

**Lösning:**
Jag använde `foremost`, ett klassiskt verktyg för "file carving", för att försöka återställa raderade filer från avbilden. Jag specificerade att jag letade efter PDF-filer:

```bash
foremost -t pdf -i alex_usb.img -o recovered_files
```

Verktyget lyckades återställa en PDF-fil. När jag undersökte filens metadata hittade jag den första delen av lösenordet: `framtiden...`. I slutet av själva dokumentet låg flaggan.

> **🚩 Flagg 4:** `CTF{inget_försvinner_för_alltid}`

**Key Takeaway:** "Raderat" betyder sällan "borta för alltid". Detta är en grundpelare inom digital forensik och en påminnelse om vikten av säker radering (`shred`, `wipe`) när data verkligen måste förstöras.

---

### Del 5 – Alex på kartan (OSINT)

**Uppdraget:** Med pusselbitarna på plats kunde vi nu kombinera de två lösenordsdelarna: `framtiden` + `är_hemligheten` = `framtidenärhemligheten`. Detta lösenord gav oss tillgång till Alexs låsta blogg, där det sista spåret väntade.

**Min tankeprocess:** Blogginlägget innehöll bara en bild på en kaffekopp. Detta är ett typiskt OSINT-scenario (Open Source Intelligence), där information hämtas från öppna källor. Bildens metadata (EXIF) är det första stället att leta efter geografiska ledtrådar.

**Lösning:**
Jag laddade ner bilden och använde en EXIF-läsare online för att inspektera dess metadata. Mycket riktigt – datan innehöll exakta GPS-koordinater och, som en sista bonus, den slutgiltiga flaggan.

> **🚩 Flagg 5:** `CTF{jag_är_på_säker_plats}`

**Key Takeaway:** Var medveten om vilket digitalt fotavtryck du lämnar. Bilder tagna med en smartphone bäddar nästan alltid in platsdata. Perfekt för semesterbilder, men en potentiell säkerhetsrisk om det publiceras ogenomtänkt.

---

## Sammanfattning och Slutsatser

Denna CTF var en utmärkt resa genom fem centrala discipliner inom cybersäkerhet. Den visade hur olika tekniker kan vävas samman för att avslöja information bit för bit.

| Del | Teknik | Pusselbit |
|:---:|--------------------|--------------------------------------|
| 1 | Web Exploitation | Tillgång till systemet |
| 2 | Kryptografi | Ledtråd om ett tvådelat lösenord |
| 3 | Steganografi | Lösenordsdel 2: `...är_hemligheten` |
| 4 | Forensik | Lösenordsdel 1: `framtiden...` |
| 5 | OSINT | Alexs slutgiltiga position |

Varje steg underströk vikten av noggrannhet och att alltid fråga sig: "Finns det mer här än vad ögat ser?". 

Det var både kul och lärorikt att skapa upp denna utmaning och jag hoppas att det också va roligt att lösa den. Tack!