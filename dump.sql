--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'LATIN1';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: tk; Type: SCHEMA; Schema: -; Owner: vm92179
--

CREATE SCHEMA tk;


ALTER SCHEMA tk OWNER TO vm92179;

--
-- Name: yk; Type: SCHEMA; Schema: -; Owner: vm92179
--

CREATE SCHEMA yk;


ALTER SCHEMA yk OWNER TO vm92179;

--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE OR REPLACE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: aanestyspaikka; Type: TABLE; Schema: public; Owner: vm92179; Tablespace: 
--

CREATE TABLE aanestyspaikka (
    nimi character varying(30) NOT NULL,
    tunnus character varying(10) NOT NULL
);


ALTER TABLE public.aanestyspaikka OWNER TO vm92179;

--
-- Name: edustaja; Type: TABLE; Schema: public; Owner: vm92179; Tablespace: 
--

CREATE TABLE edustaja (
    vaalinumero integer NOT NULL,
    vaaliliitto character varying(10),
    vaalirengas character varying(10),
    vertailuluku double precision,
    rengasvertailuluku double precision,
    arvonnoissa character varying(10)
);


ALTER TABLE public.edustaja OWNER TO vm92179;

--
-- Name: opiskelija; Type: TABLE; Schema: public; Owner: vm92179; Tablespace: 
--

CREATE TABLE opiskelija (
    opiskelijanumero integer NOT NULL,
    etunimi character varying(20) NOT NULL,
    sukunimi character varying(20) NOT NULL
);


ALTER TABLE public.opiskelija OWNER TO vm92179;

--
-- Name: paikka_aanet; Type: TABLE; Schema: public; Owner: vm92179; Tablespace: 
--

CREATE TABLE paikka_aanet (
    ehdokas_id integer NOT NULL,
    paikka_tunnus character varying(10) NOT NULL,
    lkm integer
);


ALTER TABLE public.paikka_aanet OWNER TO vm92179;

--
-- Name: tilit; Type: TABLE; Schema: public; Owner: vm92179; Tablespace: 
--

CREATE TABLE tilit (
    tilinumero character varying(40) NOT NULL,
    saldo integer NOT NULL
);


ALTER TABLE public.tilit OWNER TO vm92179;

--
-- Name: vaaliliitto; Type: TABLE; Schema: public; Owner: vm92179; Tablespace: 
--

CREATE TABLE vaaliliitto (
    nimi character varying(30) NOT NULL,
    tunnus character varying(10) NOT NULL,
    vaalirengas character varying(10)
);


ALTER TABLE public.vaaliliitto OWNER TO vm92179;

--
-- Name: vaalirengas; Type: TABLE; Schema: public; Owner: vm92179; Tablespace: 
--

CREATE TABLE vaalirengas (
    nimi character varying(30) NOT NULL,
    tunnus character varying(10) NOT NULL
);


ALTER TABLE public.vaalirengas OWNER TO vm92179;

SET search_path = tk, pg_catalog;

--
-- Name: tilit; Type: TABLE; Schema: tk; Owner: vm92179; Tablespace: 
--

CREATE TABLE tilit (
    tilinumero character varying(30) NOT NULL,
    saldo double precision
);


ALTER TABLE tk.tilit OWNER TO vm92179;

SET search_path = yk, pg_catalog;

--
-- Name: kurssit; Type: TABLE; Schema: yk; Owner: vm92179; Tablespace: 
--

CREATE TABLE kurssit (
    kurssinro integer NOT NULL,
    kurssinimi character varying(30) NOT NULL,
    opettaja character varying(30),
    pisteet integer
);


ALTER TABLE yk.kurssit OWNER TO vm92179;

--
-- Name: opiskelija; Type: TABLE; Schema: yk; Owner: vm92179; Tablespace: 
--

CREATE TABLE opiskelija (
    opnum integer NOT NULL,
    nimi character varying(30) NOT NULL,
    paa_aine character varying(30) NOT NULL,
    keskiarvo double precision
);


ALTER TABLE yk.opiskelija OWNER TO vm92179;

--
-- Name: suoritus; Type: TABLE; Schema: yk; Owner: vm92179; Tablespace: 
--

CREATE TABLE suoritus (
    onro integer NOT NULL,
    knro integer NOT NULL,
    arvosana integer NOT NULL
);


ALTER TABLE yk.suoritus OWNER TO vm92179;

SET search_path = public, pg_catalog;

--
-- Data for Name: aanestyspaikka; Type: TABLE DATA; Schema: public; Owner: vm92179
--

COPY aanestyspaikka (nimi, tunnus) FROM stdin;
Paatalo	PT1
PinniB	PB1
\.


--
-- Data for Name: edustaja; Type: TABLE DATA; Schema: public; Owner: vm92179
--

COPY edustaja (vaalinumero, vaaliliitto, vaalirengas, vertailuluku, rengasvertailuluku, arvonnoissa) FROM stdin;
123456	ET1	YH1	600	550	LI
11123	\N	YH1	150	275	RE
11126	ET1	YH1	300	183.333329999999989	RE
11124	KT1	\N	233.333329999999989	233.333329999999989	LI
11122	ET1	\N	400	400	LI
11125	ET1	\N	240	240	LI
92179	KT1	\N	350	350	LI
443234	KT1	\N	700	700	\N
54654	ET1	\N	200	200	\N
87214	ET1	\N	1200	1200	\N
\.


--
-- Data for Name: opiskelija; Type: TABLE DATA; Schema: public; Owner: vm92179
--

COPY opiskelija (opiskelijanumero, etunimi, sukunimi) FROM stdin;
92179	Ville	Murtonen
123456	Matti	Meikalainen
443234	Mikko	Mallikas
11122	Sanna	Sukunimi
11123	Siiri	Testikas
11124	Pertti	Perus
11125	Otto	Olio
11126	Esko	Erikoinen
87214	Pekka	Ilmarinen
54654	Jaakko	Parantainen
\.


--
-- Data for Name: paikka_aanet; Type: TABLE DATA; Schema: public; Owner: vm92179
--

COPY paikka_aanet (ehdokas_id, paikka_tunnus, lkm) FROM stdin;
11122	PT1	150
11123	PT1	150
11124	PT1	100
11126	PB1	150
11125	PB1	100
11122	PB1	100
11125	PT1	50
92179	PT1	100
443234	PT1	500
123456	PB1	250
54654	PT1	100
87214	PB1	300
\.


--
-- Data for Name: tilit; Type: TABLE DATA; Schema: public; Owner: vm92179
--

COPY tilit (tilinumero, saldo) FROM stdin;
10037-12345	100
20028-12356	900
\.


--
-- Data for Name: vaaliliitto; Type: TABLE DATA; Schema: public; Owner: vm92179
--

COPY vaaliliitto (nimi, tunnus, vaalirengas) FROM stdin;
Etevat	ET1	\N
Katevat	KT1	\N
\.


--
-- Data for Name: vaalirengas; Type: TABLE DATA; Schema: public; Owner: vm92179
--

COPY vaalirengas (nimi, tunnus) FROM stdin;
Yhtyneet	YH1
\.


SET search_path = tk, pg_catalog;

--
-- Data for Name: tilit; Type: TABLE DATA; Schema: tk; Owner: vm92179
--

COPY tilit (tilinumero, saldo) FROM stdin;
800028-1743212	50000.0999999999985
\.


SET search_path = yk, pg_catalog;

--
-- Data for Name: kurssit; Type: TABLE DATA; Schema: yk; Owner: vm92179
--

COPY kurssit (kurssinro, kurssinimi, opettaja, pisteet) FROM stdin;
33200	Tietotekniikan peruskurssi	Mikko Meikalainen	5
33500	Englannin peruskurssi	Mikko Meikalainen	3
\.


--
-- Data for Name: opiskelija; Type: TABLE DATA; Schema: yk; Owner: vm92179
--

COPY opiskelija (opnum, nimi, paa_aine, keskiarvo) FROM stdin;
76408	Riina Ikonen	Pohjoismaiset Kielet	2.5
92179	Ville Murtonen	Tietojenkasittely	2.375
\.


--
-- Data for Name: suoritus; Type: TABLE DATA; Schema: yk; Owner: vm92179
--

COPY suoritus (onro, knro, arvosana) FROM stdin;
76408	33500	5
92179	33200	3
92179	33500	1
76408	33200	1
\.


SET search_path = public, pg_catalog;

--
-- Name: aanestyspaikka_pkey; Type: CONSTRAINT; Schema: public; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY aanestyspaikka
    ADD CONSTRAINT aanestyspaikka_pkey PRIMARY KEY (tunnus);


--
-- Name: edustaja_pkey; Type: CONSTRAINT; Schema: public; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY edustaja
    ADD CONSTRAINT edustaja_pkey PRIMARY KEY (vaalinumero);


--
-- Name: opiskelija_pkey; Type: CONSTRAINT; Schema: public; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY opiskelija
    ADD CONSTRAINT opiskelija_pkey PRIMARY KEY (opiskelijanumero);


--
-- Name: tilit_pkey; Type: CONSTRAINT; Schema: public; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY tilit
    ADD CONSTRAINT tilit_pkey PRIMARY KEY (tilinumero);


--
-- Name: vaaliliitto_pkey; Type: CONSTRAINT; Schema: public; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY vaaliliitto
    ADD CONSTRAINT vaaliliitto_pkey PRIMARY KEY (tunnus);


--
-- Name: vaalirengas_pkey; Type: CONSTRAINT; Schema: public; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY vaalirengas
    ADD CONSTRAINT vaalirengas_pkey PRIMARY KEY (tunnus);


SET search_path = tk, pg_catalog;

--
-- Name: tilit_pkey; Type: CONSTRAINT; Schema: tk; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY tilit
    ADD CONSTRAINT tilit_pkey PRIMARY KEY (tilinumero);


SET search_path = yk, pg_catalog;

--
-- Name: kurssit_pkey; Type: CONSTRAINT; Schema: yk; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY kurssit
    ADD CONSTRAINT kurssit_pkey PRIMARY KEY (kurssinro);


--
-- Name: opiskelija_pkey; Type: CONSTRAINT; Schema: yk; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY opiskelija
    ADD CONSTRAINT opiskelija_pkey PRIMARY KEY (opnum);


--
-- Name: suoritus_pkey; Type: CONSTRAINT; Schema: yk; Owner: vm92179; Tablespace: 
--

ALTER TABLE ONLY suoritus
    ADD CONSTRAINT suoritus_pkey PRIMARY KEY (onro, knro);


SET search_path = public, pg_catalog;

--
-- Name: edustaja_vaaliliitto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: vm92179
--

ALTER TABLE ONLY edustaja
    ADD CONSTRAINT edustaja_vaaliliitto_fkey FOREIGN KEY (vaaliliitto) REFERENCES vaaliliitto(tunnus);


--
-- Name: edustaja_vaalinumero_fkey; Type: FK CONSTRAINT; Schema: public; Owner: vm92179
--

ALTER TABLE ONLY edustaja
    ADD CONSTRAINT edustaja_vaalinumero_fkey FOREIGN KEY (vaalinumero) REFERENCES opiskelija(opiskelijanumero);


--
-- Name: edustaja_vaalirengas_fkey; Type: FK CONSTRAINT; Schema: public; Owner: vm92179
--

ALTER TABLE ONLY edustaja
    ADD CONSTRAINT edustaja_vaalirengas_fkey FOREIGN KEY (vaalirengas) REFERENCES vaalirengas(tunnus);


--
-- Name: paikka_aanet_ehdokas_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: vm92179
--

ALTER TABLE ONLY paikka_aanet
    ADD CONSTRAINT paikka_aanet_ehdokas_id_fkey FOREIGN KEY (ehdokas_id) REFERENCES edustaja(vaalinumero);


--
-- Name: paikka_aanet_paikka_tunnus_fkey; Type: FK CONSTRAINT; Schema: public; Owner: vm92179
--

ALTER TABLE ONLY paikka_aanet
    ADD CONSTRAINT paikka_aanet_paikka_tunnus_fkey FOREIGN KEY (paikka_tunnus) REFERENCES aanestyspaikka(tunnus);


--
-- Name: vaaliliitto_vaalirengas_fkey; Type: FK CONSTRAINT; Schema: public; Owner: vm92179
--

ALTER TABLE ONLY vaaliliitto
    ADD CONSTRAINT vaaliliitto_vaalirengas_fkey FOREIGN KEY (vaalirengas) REFERENCES vaalirengas(tunnus);


SET search_path = yk, pg_catalog;

--
-- Name: suoritus_knro_fkey; Type: FK CONSTRAINT; Schema: yk; Owner: vm92179
--

ALTER TABLE ONLY suoritus
    ADD CONSTRAINT suoritus_knro_fkey FOREIGN KEY (knro) REFERENCES kurssit(kurssinro);


--
-- Name: suoritus_onro_fkey; Type: FK CONSTRAINT; Schema: yk; Owner: vm92179
--

ALTER TABLE ONLY suoritus
    ADD CONSTRAINT suoritus_onro_fkey FOREIGN KEY (onro) REFERENCES opiskelija(opnum);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

