--
-- PostgreSQL database dump
--

-- Dumped from database version 10.1
-- Dumped by pg_dump version 10.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: evenement; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE evenement (
    id integer NOT NULL,
    fiction_id integer,
    annee_debut integer NOT NULL,
    annee_fin integer NOT NULL,
    date_creation timestamp(0) without time zone NOT NULL,
    date_modification timestamp(0) without time zone NOT NULL,
    uuid uuid NOT NULL,
    titre character varying(255) NOT NULL,
    description text NOT NULL
);


ALTER TABLE evenement OWNER TO postgres;

--
-- Name: evenement_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE evenement_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE evenement_id_seq OWNER TO postgres;

--
-- Name: fiction; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE fiction (
    id integer NOT NULL,
    date_creation timestamp(0) without time zone NOT NULL,
    date_modification timestamp(0) without time zone NOT NULL,
    uuid uuid NOT NULL,
    titre character varying(255) NOT NULL,
    description text NOT NULL
);


ALTER TABLE fiction OWNER TO postgres;

--
-- Name: fiction_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE fiction_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE fiction_id_seq OWNER TO postgres;

--
-- Name: personnage; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE personnage (
    id integer NOT NULL,
    fiction_id integer,
    annee_naissance integer,
    annee_mort integer,
    nom character varying(255) DEFAULT NULL::character varying,
    prenom character varying(255) DEFAULT NULL::character varying,
    genre character varying(255) DEFAULT NULL::character varying,
    date_creation timestamp(0) without time zone NOT NULL,
    date_modification timestamp(0) without time zone NOT NULL,
    uuid uuid NOT NULL,
    titre character varying(255) NOT NULL,
    description text NOT NULL
);


ALTER TABLE personnage OWNER TO postgres;

--
-- Name: personnage_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE personnage_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE personnage_id_seq OWNER TO postgres;

--
-- Name: texte; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE texte (
    id integer NOT NULL,
    fiction_id integer,
    type character varying(255) NOT NULL,
    date_creation timestamp(0) without time zone NOT NULL,
    date_modification timestamp(0) without time zone NOT NULL,
    uuid uuid NOT NULL,
    titre character varying(255) NOT NULL,
    description text NOT NULL
);


ALTER TABLE texte OWNER TO postgres;

--
-- Name: texte_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE texte_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE texte_id_seq OWNER TO postgres;

--
-- Data for Name: evenement; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY evenement (id, fiction_id, annee_debut, annee_fin, date_creation, date_modification, uuid, titre, description) FROM stdin;
1	1	0	3	2018-04-28 17:52:21	2018-04-28 17:52:21	b029f9a2-c0c0-48b9-d64d-52312532d296	Titre d'évènement	Description d'évènement
2	1	3	6	2018-04-28 17:52:21	2018-04-28 17:52:21	64381e8c-8695-42c7-fece-247015b55589	Titre d'évènement 2	Description d'évènement 2
\.


--
-- Data for Name: fiction; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY fiction (id, date_creation, date_modification, uuid, titre, description) FROM stdin;
1	2018-04-28 17:52:21	2018-04-28 17:52:21	80e9d5a2-c975-4fc9-ef88-4a4a482f83d2	Test avec évènements	Description test
\.


--
-- Data for Name: personnage; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY personnage (id, fiction_id, annee_naissance, annee_mort, nom, prenom, genre, date_creation, date_modification, uuid, titre, description) FROM stdin;
1	1	0	100	\N	\N	\N	2018-04-28 17:52:21	2018-04-28 17:52:21	807c8979-13f1-48bc-f70a-bf0baab55af8	personnage	Description du pesonnage
2	1	0	100	\N	\N	\N	2018-04-28 17:52:21	2018-04-28 17:52:21	9eaf024a-7528-4f24-ec44-f7d4bdda4cc8	personnage 2	Description du pesonnage
\.


--
-- Data for Name: texte; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY texte (id, fiction_id, type, date_creation, date_modification, uuid, titre, description) FROM stdin;
1	1	promesse	2018-04-28 17:52:21	2018-04-28 17:52:21	c14a0976-a1da-4c62-a49d-3429930d9349	Titre de texte 1	Description 1
2	1	promesse	2018-04-28 17:52:21	2018-04-28 17:52:21	47c7fc8d-04c8-431a-bd80-acad1b202a5c	Titre de texte 2	Description 2
\.


--
-- Name: evenement_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('evenement_id_seq', 2, true);


--
-- Name: fiction_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('fiction_id_seq', 1, true);


--
-- Name: personnage_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('personnage_id_seq', 2, true);


--
-- Name: texte_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('texte_id_seq', 2, true);


--
-- Name: evenement evenement_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_pkey PRIMARY KEY (id);


--
-- Name: fiction fiction_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY fiction
    ADD CONSTRAINT fiction_pkey PRIMARY KEY (id);


--
-- Name: personnage personnage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY personnage
    ADD CONSTRAINT personnage_pkey PRIMARY KEY (id);


--
-- Name: texte texte_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY texte
    ADD CONSTRAINT texte_pkey PRIMARY KEY (id);


--
-- Name: idx_6aea486dff905ac2; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_6aea486dff905ac2 ON personnage USING btree (fiction_id);


--
-- Name: idx_b26681eff905ac2; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_b26681eff905ac2 ON evenement USING btree (fiction_id);


--
-- Name: idx_eae1a6eeff905ac2; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_eae1a6eeff905ac2 ON texte USING btree (fiction_id);


--
-- Name: personnage fk_6aea486dff905ac2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY personnage
    ADD CONSTRAINT fk_6aea486dff905ac2 FOREIGN KEY (fiction_id) REFERENCES fiction(id);


--
-- Name: evenement fk_b26681eff905ac2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT fk_b26681eff905ac2 FOREIGN KEY (fiction_id) REFERENCES fiction(id);


--
-- Name: texte fk_eae1a6eeff905ac2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY texte
    ADD CONSTRAINT fk_eae1a6eeff905ac2 FOREIGN KEY (fiction_id) REFERENCES fiction(id);


--
-- PostgreSQL database dump complete
--

