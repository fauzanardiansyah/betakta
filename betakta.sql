--
-- PostgreSQL database dump
--

-- Dumped from database version 11.11
-- Dumped by pg_dump version 11.11

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: category_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.category_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.category_seq OWNER TO zero;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: category; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.category (
    id integer DEFAULT nextval('public.category_seq'::regclass) NOT NULL,
    nama_category character varying(191) NOT NULL
);


ALTER TABLE public.category OWNER TO zero;

--
-- Name: comment_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.comment_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comment_seq OWNER TO zero;

--
-- Name: comment; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.comment (
    id integer DEFAULT nextval('public.comment_seq'::regclass) NOT NULL,
    id_post integer NOT NULL,
    name character varying(191) NOT NULL,
    email character varying(191) NOT NULL,
    website character varying(191) NOT NULL,
    reply text NOT NULL,
    date timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.comment OWNER TO zero;

--
-- Name: faq_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.faq_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.faq_seq OWNER TO zero;

--
-- Name: faq; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.faq (
    id integer DEFAULT nextval('public.faq_seq'::regclass) NOT NULL,
    question character varying(191) NOT NULL,
    answer text NOT NULL
);


ALTER TABLE public.faq OWNER TO zero;

--
-- Name: jobs_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.jobs_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jobs_seq OWNER TO zero;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.jobs (
    id bigint DEFAULT nextval('public.jobs_seq'::regclass) NOT NULL,
    queue character varying(191) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL,
    CONSTRAINT jobs_attempts_check CHECK ((attempts > 0)),
    CONSTRAINT jobs_available_at_check CHECK ((available_at > 0)),
    CONSTRAINT jobs_created_at_check CHECK ((created_at > 0)),
    CONSTRAINT jobs_id_check CHECK ((id > 0)),
    CONSTRAINT jobs_reserved_at_check CHECK ((reserved_at > 0))
);


ALTER TABLE public.jobs OWNER TO zero;

--
-- Name: migrations_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.migrations_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_seq OWNER TO zero;

--
-- Name: migrations; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.migrations (
    id integer DEFAULT nextval('public.migrations_seq'::regclass) NOT NULL,
    migration character varying(191) NOT NULL,
    batch integer NOT NULL,
    CONSTRAINT migrations_id_check CHECK ((id > 0))
);


ALTER TABLE public.migrations OWNER TO zero;

--
-- Name: notifications; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.notifications (
    id character(36) NOT NULL,
    type character varying(191) NOT NULL,
    notifiable_type character varying(191) NOT NULL,
    notifiable_id bigint NOT NULL,
    data text NOT NULL,
    read_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT notifications_notifiable_id_check CHECK ((notifiable_id > 0))
);


ALTER TABLE public.notifications OWNER TO zero;

--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.password_resets (
    email character varying(191) NOT NULL,
    token character varying(191) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.password_resets OWNER TO zero;

--
-- Name: post_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.post_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.post_seq OWNER TO zero;

--
-- Name: post; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.post (
    id integer DEFAULT nextval('public.post_seq'::regclass) NOT NULL,
    id_category integer NOT NULL,
    title character varying(191) NOT NULL,
    slug character varying(191) NOT NULL,
    date timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    cover character varying(191) NOT NULL,
    news text NOT NULL
);


ALTER TABLE public.post OWNER TO zero;

--
-- Name: provinsi_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.provinsi_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.provinsi_seq OWNER TO zero;

--
-- Name: provinsi; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.provinsi (
    id integer DEFAULT nextval('public.provinsi_seq'::regclass) NOT NULL,
    kd_provinsi integer NOT NULL,
    name character varying(191) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    no_urut_1 integer,
    no_urut_2 integer,
    CONSTRAINT provinsi_id_check CHECK ((id > 0))
);


ALTER TABLE public.provinsi OWNER TO zero;

--
-- Name: sponsorship_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.sponsorship_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sponsorship_seq OWNER TO zero;

--
-- Name: sponsorship; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.sponsorship (
    id integer DEFAULT nextval('public.sponsorship_seq'::regclass) NOT NULL,
    logo_bu character varying(191) NOT NULL
);


ALTER TABLE public.sponsorship OWNER TO zero;

--
-- Name: super_admin_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.super_admin_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.super_admin_seq OWNER TO zero;

--
-- Name: t_administrasi_kta_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_administrasi_kta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_administrasi_kta_seq OWNER TO zero;

--
-- Name: t_administrasi_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_administrasi_kta (
    id integer DEFAULT nextval('public.t_administrasi_kta_seq'::regclass) NOT NULL,
    id_detail_kta character(36) NOT NULL,
    alamat text NOT NULL,
    kecamatan character varying(30) NOT NULL,
    kota character varying(30) NOT NULL,
    kd_pos character varying(30) NOT NULL,
    no_telp character varying(13) NOT NULL,
    no_fax character varying(30) DEFAULT NULL::character varying,
    website character varying(40) DEFAULT NULL::character varying,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_administrasi_kta_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_administrasi_kta OWNER TO zero;

--
-- Name: t_app_kta_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_app_kta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_app_kta_seq OWNER TO zero;

--
-- Name: t_app_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_app_kta (
    id integer DEFAULT nextval('public.t_app_kta_seq'::regclass) NOT NULL,
    id_detail_kta character(36) NOT NULL,
    status_pengajuan integer NOT NULL,
    tgl_status timestamp(0) without time zone NOT NULL,
    keterangan text NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_app_kta_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_app_kta OWNER TO zero;

--
-- Name: t_detail_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_detail_kta (
    id character(36) NOT NULL,
    id_kta character(36) NOT NULL,
    jenis_pengajuan integer NOT NULL,
    waktu_pengajuan timestamp(0) without time zone NOT NULL,
    tgl_terbit date,
    masa_berlaku date NOT NULL,
    view_notifikasi integer NOT NULL,
    view_notifikasi_dpp integer NOT NULL,
    view_notifikasi_dpn integer NOT NULL,
    is_inserted smallint NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.t_detail_kta OWNER TO zero;

--
-- Name: t_detail_legalitas_kta_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_detail_legalitas_kta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_detail_legalitas_kta_seq OWNER TO zero;

--
-- Name: t_detail_legalitas_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_detail_legalitas_kta (
    id integer DEFAULT nextval('public.t_detail_legalitas_kta_seq'::regclass) NOT NULL,
    id_legalitas_bu integer NOT NULL,
    no_akte_perubahan character varying(191) DEFAULT NULL::character varying,
    nm_notaris_perubahan character varying(191) DEFAULT NULL::character varying,
    tgl_akte_perubahan_keluar character varying(225) DEFAULT NULL::character varying,
    maksud_tujuan_akte_perubahan text,
    no_sk_perubahan character varying(191) DEFAULT NULL::character varying,
    tgl_sk_perubahan_keluar character varying(225) DEFAULT NULL::character varying,
    nama_kbli character varying(191) DEFAULT NULL::character varying,
    no_kbli character varying(191) DEFAULT NULL::character varying,
    CONSTRAINT t_detail_legalitas_kta_id_check CHECK ((id > 0)),
    CONSTRAINT t_detail_legalitas_kta_id_legalitas_bu_check CHECK ((id_legalitas_bu > 0))
);


ALTER TABLE public.t_detail_legalitas_kta OWNER TO zero;

--
-- Name: t_dokumen_kta_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_dokumen_kta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_dokumen_kta_seq OWNER TO zero;

--
-- Name: t_dokumen_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_dokumen_kta (
    id integer DEFAULT nextval('public.t_dokumen_kta_seq'::regclass) NOT NULL,
    id_detail_kta character(36) NOT NULL,
    file_ktp_pjbu character varying(50) NOT NULL,
    file_foto_pjbu character varying(50) NOT NULL,
    file_npwp_pjbu character varying(50) NOT NULL,
    file_ijazah_pjbu character varying(50) NOT NULL,
    file_npwp_bu character varying(50) NOT NULL,
    file_akte_pendirian_perubahan_bu character varying(50) NOT NULL,
    file_sk_pendirian_perubahan_bu character varying(50) NOT NULL,
    file_skdp_bu character varying(50) DEFAULT NULL::character varying,
    file_siup character varying(50) DEFAULT NULL::character varying,
    file_tdp character varying(50) DEFAULT NULL::character varying,
    file_nib character varying(50) DEFAULT NULL::character varying,
    file_kta character varying(50) DEFAULT NULL::character varying,
    surat_permohonan_baru character varying(50) DEFAULT NULL::character varying,
    surat_permohonan_perpanjang character varying(50) DEFAULT NULL::character varying,
    surat_permohonan_daftar_ulang character varying(50) DEFAULT NULL::character varying,
    dokumen_pemberhentian character varying(225) DEFAULT NULL::character varying,
    file_siujk character varying(50) DEFAULT NULL::character varying,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_dokumen_kta_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_dokumen_kta OWNER TO zero;

--
-- Name: t_dp_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_dp_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_dp_seq OWNER TO zero;

--
-- Name: t_dp; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_dp (
    id integer DEFAULT nextval('public.t_dp_seq'::regclass) NOT NULL,
    id_provinsi integer NOT NULL,
    level integer NOT NULL,
    no_rek character varying(191) NOT NULL,
    nm_rek character varying(191) NOT NULL,
    kode_bank character varying(191) NOT NULL,
    nm_bank character varying(20) NOT NULL,
    iuran_1_thn_kecil integer,
    iuran_1_thn_menengah integer,
    iuran_1_thn_besar integer,
    uang_pangkal integer,
    role_share_iuran_kecil integer,
    role_share_iuran_menengah integer,
    role_share_iuran_besar integer,
    role_share_uang_pangkal integer,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    nm_ketua_provinsi character varying(40) DEFAULT NULL::character varying,
    nm_sekretaris_provinsi character varying(40) DEFAULT NULL::character varying,
    ttd_ketua_provinsi character varying(191) DEFAULT NULL::character varying,
    ttd_sekretaris_provinsi character varying(191) DEFAULT NULL::character varying,
    nm_ketum character varying(40) DEFAULT NULL::character varying,
    nm_sekjen character varying(40) DEFAULT NULL::character varying,
    foto_profile_dpp character varying(191) DEFAULT NULL::character varying,
    foto_profile_dpn character varying(191) DEFAULT NULL::character varying,
    ketua_bkka character varying(191) DEFAULT NULL::character varying,
    sekretaris_bkka character varying(191) DEFAULT NULL::character varying,
    ttd_ketua_bkka character varying(191) DEFAULT NULL::character varying,
    ttd_sekretaris_bkka character varying(191) DEFAULT NULL::character varying,
    ttd_ketum character varying(191) DEFAULT NULL::character varying,
    ttd_sekjen character varying(191) DEFAULT NULL::character varying,
    alamat text NOT NULL,
    email_dewan_pengurus character varying(191) NOT NULL,
    no_telp_dewan_pengurus character varying(191) NOT NULL,
    no_rek_bkka character varying(191) DEFAULT NULL::character varying,
    nm_bank_bkka character varying(191) DEFAULT NULL::character varying,
    nm_rek_bkka character varying(191) DEFAULT NULL::character varying,
    uang_gedung numeric(50,0) DEFAULT 0,
    CONSTRAINT t_dp_id_check CHECK ((id > 0)),
    CONSTRAINT t_dp_id_provinsi_check CHECK ((id_provinsi > 0))
);


ALTER TABLE public.t_dp OWNER TO zero;

--
-- Name: t_invoice_kta_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_invoice_kta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_invoice_kta_seq OWNER TO zero;

--
-- Name: t_invoice_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_invoice_kta (
    id integer DEFAULT nextval('public.t_invoice_kta_seq'::regclass) NOT NULL,
    id_detail_kta character(36) NOT NULL,
    no_invoice character varying(191) NOT NULL,
    jenis_pengajuan integer NOT NULL,
    jml_tagihan integer NOT NULL,
    tgl_cetak timestamp(0) without time zone NOT NULL,
    status_pembayaran integer NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    rincian_tanggal_bayar text,
    CONSTRAINT t_invoice_kta_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_invoice_kta OWNER TO zero;

--
-- Name: t_invoice_role_share_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_invoice_role_share_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_invoice_role_share_seq OWNER TO zero;

--
-- Name: t_invoice_role_share; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_invoice_role_share (
    id integer DEFAULT nextval('public.t_invoice_role_share_seq'::regclass) NOT NULL,
    id_detail_kta character(36) NOT NULL,
    no_invoice character varying(191) NOT NULL,
    jenis_pengajuan integer NOT NULL,
    jml_tagihan_agt integer NOT NULL,
    total_role_share integer NOT NULL,
    tgl_cetak timestamp(0) without time zone NOT NULL,
    status_pembayaran integer NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    rincian_tanggal_bayar text,
    CONSTRAINT t_invoice_role_share_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_invoice_role_share OWNER TO zero;

--
-- Name: t_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_kta (
    id character(36) NOT NULL,
    id_registrasi_users integer NOT NULL,
    id_dp integer NOT NULL,
    jenis_bu character varying(50) NOT NULL,
    lokasi_pengurusan character varying(191) NOT NULL,
    no_kta character varying(191) DEFAULT NULL::character varying,
    status_kta integer NOT NULL,
    status_penataran integer NOT NULL,
    kualifikasi character varying(50) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    registration_until_date timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    sisa_bulan integer DEFAULT 0,
    CONSTRAINT t_kta_id_dp_check CHECK ((id_dp > 0)),
    CONSTRAINT t_kta_id_registrasi_users_check CHECK ((id_registrasi_users > 0))
);


ALTER TABLE public.t_kta OWNER TO zero;

--
-- Name: t_legalitas_kta_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_legalitas_kta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_legalitas_kta_seq OWNER TO zero;

--
-- Name: t_legalitas_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_legalitas_kta (
    id integer DEFAULT nextval('public.t_legalitas_kta_seq'::regclass) NOT NULL,
    id_detail_kta character(36) NOT NULL,
    no_siup character varying(225) DEFAULT NULL::character varying,
    penerbit_siup character varying(225) DEFAULT NULL::character varying,
    tgl_keluar_siup character varying(225) DEFAULT NULL::character varying,
    masa_berlaku_siup character varying(225) DEFAULT NULL::character varying,
    no_skdp character varying(225) DEFAULT NULL::character varying,
    penerbit_skdp character varying(225) DEFAULT NULL::character varying,
    tgl_keluar_skdp character varying(225) DEFAULT NULL::character varying,
    masa_berlaku_skdp character varying(225) DEFAULT NULL::character varying,
    no_akte character varying(225) NOT NULL,
    nm_notaris character varying(225) NOT NULL,
    tgl_keluar_akte character varying(225) NOT NULL,
    maksud_tujuan_akte text,
    no_sk_pendirian character varying(225) NOT NULL,
    tgl_sk_pendirian_keluar character varying(225) NOT NULL,
    no_tdp character varying(225) DEFAULT NULL::character varying,
    penerbit_tdp character varying(225) DEFAULT NULL::character varying,
    tgl_keluar_tdp character varying(225) DEFAULT NULL::character varying,
    masa_berlaku_tdp character varying(225) DEFAULT NULL::character varying,
    no_nib character varying(225) DEFAULT NULL::character varying,
    tgl_keluar_nib character varying(225) DEFAULT NULL::character varying,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_legalitas_kta_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_legalitas_kta OWNER TO zero;

--
-- Name: t_payment_confirmation_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_payment_confirmation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_payment_confirmation_seq OWNER TO zero;

--
-- Name: t_payment_confirmation; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_payment_confirmation (
    id integer DEFAULT nextval('public.t_payment_confirmation_seq'::regclass) NOT NULL,
    id_invoice_kta integer NOT NULL,
    no_invoice character varying(191) NOT NULL,
    nominal character varying(191) NOT NULL,
    upload_bukti_trf character varying(191) DEFAULT NULL::character varying,
    atas_nama character varying(191) NOT NULL,
    nama_bank_anda character varying(191) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_payment_confirmation_id_check CHECK ((id > 0)),
    CONSTRAINT t_payment_confirmation_id_invoice_kta_check CHECK ((id_invoice_kta > 0))
);


ALTER TABLE public.t_payment_confirmation OWNER TO zero;

--
-- Name: t_pemberhentian_agt_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_pemberhentian_agt_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_pemberhentian_agt_seq OWNER TO zero;

--
-- Name: t_pemberhentian_agt; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_pemberhentian_agt (
    id integer DEFAULT nextval('public.t_pemberhentian_agt_seq'::regclass) NOT NULL,
    id_detail_kta character(36) NOT NULL,
    file_pemberhentian character varying(191) NOT NULL,
    keterangan character varying(191) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_pemberhentian_agt_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_pemberhentian_agt OWNER TO zero;

--
-- Name: t_pj_kta_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_pj_kta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_pj_kta_seq OWNER TO zero;

--
-- Name: t_pj_kta; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_pj_kta (
    id integer DEFAULT nextval('public.t_pj_kta_seq'::regclass) NOT NULL,
    id_detail_kta character(36) NOT NULL,
    nm_pjbu character varying(50) NOT NULL,
    kewarganegaraan character varying(3) NOT NULL,
    nik character varying(20) DEFAULT NULL::character varying,
    no_passport character varying(20) DEFAULT NULL::character varying,
    jabatan character varying(15) NOT NULL,
    pendidikan character varying(10) NOT NULL,
    tempat character varying(50) DEFAULT NULL::character varying,
    tgl_lahir character varying(50) DEFAULT NULL::character varying,
    alamat text NOT NULL,
    email_pjbu character varying(225) NOT NULL,
    npwp_pjbu character varying(25) NOT NULL,
    no_hp_pjbu character varying(22) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_pj_kta_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_pj_kta OWNER TO zero;

--
-- Name: t_registrasi_users_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_registrasi_users_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_registrasi_users_seq OWNER TO zero;

--
-- Name: t_registrasi_users; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_registrasi_users (
    id integer DEFAULT nextval('public.t_registrasi_users_seq'::regclass) NOT NULL,
    nm_bu character varying(191) NOT NULL,
    email_bu character varying(191) NOT NULL,
    npwp_bu character varying(191) NOT NULL,
    bentuk_bu character varying(191) NOT NULL,
    status_bu character varying(15) NOT NULL,
    password character varying(191) NOT NULL,
    remember_token character varying(191) NOT NULL,
    email_verified_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    foto_profile character varying(191) DEFAULT NULL::character varying,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_registrasi_users_id_check CHECK ((id > 0))
);


ALTER TABLE public.t_registrasi_users OWNER TO zero;

--
-- Name: t_role_share_accumulation_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_role_share_accumulation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_role_share_accumulation_seq OWNER TO zero;

--
-- Name: t_role_share_accumulation; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_role_share_accumulation (
    id integer DEFAULT nextval('public.t_role_share_accumulation_seq'::regclass) NOT NULL,
    nominal character varying(191) NOT NULL,
    upload_bukti_trf character varying(191) NOT NULL,
    atas_nama character varying(191) NOT NULL,
    nama_bank_anda character varying(191) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone NOT NULL,
    status integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.t_role_share_accumulation OWNER TO zero;

--
-- Name: t_role_share_confirmation_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_role_share_confirmation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_role_share_confirmation_seq OWNER TO zero;

--
-- Name: t_role_share_confirmation; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_role_share_confirmation (
    id integer DEFAULT nextval('public.t_role_share_confirmation_seq'::regclass) NOT NULL,
    id_invoice_role_share integer NOT NULL,
    id_role_share_accumulation integer NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_role_share_confirmation_id_check CHECK ((id > 0)),
    CONSTRAINT t_role_share_confirmation_id_invoice_role_share_check CHECK ((id_invoice_role_share > 0))
);


ALTER TABLE public.t_role_share_confirmation OWNER TO zero;

--
-- Name: t_users_dp_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_users_dp_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_users_dp_seq OWNER TO zero;

--
-- Name: t_users_dp; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_users_dp (
    id integer DEFAULT nextval('public.t_users_dp_seq'::regclass) NOT NULL,
    id_dp integer NOT NULL,
    npwp_pengurus character varying(191) NOT NULL,
    email_pengurus character varying(191) NOT NULL,
    password character varying(191) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT t_users_dp_id_check CHECK ((id > 0)),
    CONSTRAINT t_users_dp_id_dp_check CHECK ((id_dp > 0))
);


ALTER TABLE public.t_users_dp OWNER TO zero;

--
-- Name: t_warning_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.t_warning_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.t_warning_seq OWNER TO zero;

--
-- Name: t_warning; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.t_warning (
    id_warning bigint DEFAULT nextval('public.t_warning_seq'::regclass) NOT NULL,
    title character varying(191) DEFAULT NULL::character varying,
    description character varying(191) DEFAULT NULL::character varying,
    image character varying(191) DEFAULT NULL::character varying,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    status character varying(191) DEFAULT NULL::character varying,
    CONSTRAINT t_warning_id_warning_check CHECK ((id_warning > 0))
);


ALTER TABLE public.t_warning OWNER TO zero;

--
-- Name: testimonials_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.testimonials_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.testimonials_seq OWNER TO zero;

--
-- Name: testimonials; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.testimonials (
    id integer DEFAULT nextval('public.testimonials_seq'::regclass) NOT NULL,
    name character varying(30) NOT NULL,
    profile_picture character varying(100) NOT NULL,
    "position" character varying(50) NOT NULL,
    message text NOT NULL
);


ALTER TABLE public.testimonials OWNER TO zero;

--
-- Name: users_seq; Type: SEQUENCE; Schema: public; Owner: zero
--

CREATE SEQUENCE public.users_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_seq OWNER TO zero;

--
-- Name: users; Type: TABLE; Schema: public; Owner: zero
--

CREATE TABLE public.users (
    id bigint DEFAULT nextval('public.users_seq'::regclass) NOT NULL,
    name character varying(191) NOT NULL,
    email character varying(191) NOT NULL,
    email_verified_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    password character varying(191) NOT NULL,
    remember_token character varying(100) DEFAULT NULL::character varying,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT users_id_check CHECK ((id > 0))
);


ALTER TABLE public.users OWNER TO zero;

--
-- Name: category category_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_pkey PRIMARY KEY (id);


--
-- Name: comment comment_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT comment_pkey PRIMARY KEY (id);


--
-- Name: faq faq_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.faq
    ADD CONSTRAINT faq_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: post post_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT post_pkey PRIMARY KEY (id);


--
-- Name: provinsi provinsi_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.provinsi
    ADD CONSTRAINT provinsi_pkey PRIMARY KEY (id);


--
-- Name: sponsorship sponsorship_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.sponsorship
    ADD CONSTRAINT sponsorship_pkey PRIMARY KEY (id);


--
-- Name: t_administrasi_kta t_administrasi_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_administrasi_kta
    ADD CONSTRAINT t_administrasi_kta_pkey PRIMARY KEY (id);


--
-- Name: t_app_kta t_app_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_app_kta
    ADD CONSTRAINT t_app_kta_pkey PRIMARY KEY (id);


--
-- Name: t_detail_kta t_detail_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_detail_kta
    ADD CONSTRAINT t_detail_kta_pkey PRIMARY KEY (id);


--
-- Name: t_detail_legalitas_kta t_detail_legalitas_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_detail_legalitas_kta
    ADD CONSTRAINT t_detail_legalitas_kta_pkey PRIMARY KEY (id);


--
-- Name: t_dokumen_kta t_dokumen_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_dokumen_kta
    ADD CONSTRAINT t_dokumen_kta_pkey PRIMARY KEY (id);


--
-- Name: t_dp t_dp_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_dp
    ADD CONSTRAINT t_dp_pkey PRIMARY KEY (id);


--
-- Name: t_invoice_kta t_invoice_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_invoice_kta
    ADD CONSTRAINT t_invoice_kta_pkey PRIMARY KEY (id);


--
-- Name: t_invoice_role_share t_invoice_role_share_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_invoice_role_share
    ADD CONSTRAINT t_invoice_role_share_pkey PRIMARY KEY (id);


--
-- Name: t_kta t_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_kta
    ADD CONSTRAINT t_kta_pkey PRIMARY KEY (id);


--
-- Name: t_legalitas_kta t_legalitas_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_legalitas_kta
    ADD CONSTRAINT t_legalitas_kta_pkey PRIMARY KEY (id);


--
-- Name: t_payment_confirmation t_payment_confirmation_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_payment_confirmation
    ADD CONSTRAINT t_payment_confirmation_pkey PRIMARY KEY (id);


--
-- Name: t_pemberhentian_agt t_pemberhentian_agt_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_pemberhentian_agt
    ADD CONSTRAINT t_pemberhentian_agt_pkey PRIMARY KEY (id);


--
-- Name: t_pj_kta t_pj_kta_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_pj_kta
    ADD CONSTRAINT t_pj_kta_pkey PRIMARY KEY (id);


--
-- Name: t_registrasi_users t_registrasi_users_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_registrasi_users
    ADD CONSTRAINT t_registrasi_users_pkey PRIMARY KEY (id);


--
-- Name: t_role_share_accumulation t_role_share_accumulation_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_role_share_accumulation
    ADD CONSTRAINT t_role_share_accumulation_pkey PRIMARY KEY (id);


--
-- Name: t_role_share_confirmation t_role_share_confirmation_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_role_share_confirmation
    ADD CONSTRAINT t_role_share_confirmation_pkey PRIMARY KEY (id);


--
-- Name: t_users_dp t_users_dp_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_users_dp
    ADD CONSTRAINT t_users_dp_pkey PRIMARY KEY (id);


--
-- Name: t_warning t_warning_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_warning
    ADD CONSTRAINT t_warning_pkey PRIMARY KEY (id_warning);


--
-- Name: testimonials testimonials_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.testimonials
    ADD CONSTRAINT testimonials_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: category_post; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX category_post ON public.post USING btree (id_category);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: notifications_notifiable_type_notifiable_id_index; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX notifications_notifiable_type_notifiable_id_index ON public.notifications USING btree (notifiable_type, notifiable_id);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: post_comment; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX post_comment ON public.comment USING btree (id_post);


--
-- Name: t_administrasi_kta_id_detail_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_administrasi_kta_id_detail_kta_foreign ON public.t_administrasi_kta USING btree (id_detail_kta);


--
-- Name: t_app_kta_id_detail_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_app_kta_id_detail_kta_foreign ON public.t_app_kta USING btree (id_detail_kta);


--
-- Name: t_detail_kta_id_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_detail_kta_id_kta_foreign ON public.t_detail_kta USING btree (id_kta);


--
-- Name: t_detail_legalitas_kta_id_legalitas_bu_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_detail_legalitas_kta_id_legalitas_bu_foreign ON public.t_detail_legalitas_kta USING btree (id_legalitas_bu);


--
-- Name: t_dokumen_kta_id_detail_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_dokumen_kta_id_detail_kta_foreign ON public.t_dokumen_kta USING btree (id_detail_kta);


--
-- Name: t_dp_id_provinsi_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_dp_id_provinsi_foreign ON public.t_dp USING btree (id_provinsi);


--
-- Name: t_invoice_fee_dpp_id_detail_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_invoice_fee_dpp_id_detail_kta_foreign ON public.t_invoice_role_share USING btree (id_detail_kta);


--
-- Name: t_invoice_kta_id_detail_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_invoice_kta_id_detail_kta_foreign ON public.t_invoice_kta USING btree (id_detail_kta);


--
-- Name: t_kta_id_dp_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_kta_id_dp_foreign ON public.t_kta USING btree (id_dp);


--
-- Name: t_kta_id_registrasi_users_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_kta_id_registrasi_users_foreign ON public.t_kta USING btree (id_registrasi_users);


--
-- Name: t_legalitas_kta_id_detail_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_legalitas_kta_id_detail_kta_foreign ON public.t_legalitas_kta USING btree (id_detail_kta);


--
-- Name: t_payment_confirmation_id_invoice_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_payment_confirmation_id_invoice_kta_foreign ON public.t_payment_confirmation USING btree (id_invoice_kta);


--
-- Name: t_pemberhentian_agt_id_detail_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_pemberhentian_agt_id_detail_kta_foreign ON public.t_pemberhentian_agt USING btree (id_detail_kta);


--
-- Name: t_pj_kta_id_detail_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_pj_kta_id_detail_kta_foreign ON public.t_pj_kta USING btree (id_detail_kta);


--
-- Name: t_role_share_confirmation_id_invoice_kta_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_role_share_confirmation_id_invoice_kta_foreign ON public.t_role_share_confirmation USING btree (id_invoice_role_share);


--
-- Name: t_role_share_confirmation_id_role_share_accumulation_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_role_share_confirmation_id_role_share_accumulation_foreign ON public.t_role_share_confirmation USING btree (id_role_share_accumulation);


--
-- Name: t_users_dp_id_dp_foreign; Type: INDEX; Schema: public; Owner: zero
--

CREATE INDEX t_users_dp_id_dp_foreign ON public.t_users_dp USING btree (id_dp);


--
-- Name: post category_post; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.post
    ADD CONSTRAINT category_post FOREIGN KEY (id_category) REFERENCES public.category(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: comment post_comment; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.comment
    ADD CONSTRAINT post_comment FOREIGN KEY (id_post) REFERENCES public.post(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_administrasi_kta t_administrasi_kta_id_detail_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_administrasi_kta
    ADD CONSTRAINT t_administrasi_kta_id_detail_kta_foreign FOREIGN KEY (id_detail_kta) REFERENCES public.t_detail_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_app_kta t_app_kta_id_detail_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_app_kta
    ADD CONSTRAINT t_app_kta_id_detail_kta_foreign FOREIGN KEY (id_detail_kta) REFERENCES public.t_detail_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_detail_legalitas_kta t_detail_legalitas_kta_id_legalitas_bu_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_detail_legalitas_kta
    ADD CONSTRAINT t_detail_legalitas_kta_id_legalitas_bu_foreign FOREIGN KEY (id_legalitas_bu) REFERENCES public.t_legalitas_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_dokumen_kta t_dokumen_kta_id_detail_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_dokumen_kta
    ADD CONSTRAINT t_dokumen_kta_id_detail_kta_foreign FOREIGN KEY (id_detail_kta) REFERENCES public.t_detail_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_dp t_dp_id_provinsi_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_dp
    ADD CONSTRAINT t_dp_id_provinsi_foreign FOREIGN KEY (id_provinsi) REFERENCES public.provinsi(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_invoice_role_share t_invoice_fee_dpp_id_detail_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_invoice_role_share
    ADD CONSTRAINT t_invoice_fee_dpp_id_detail_kta_foreign FOREIGN KEY (id_detail_kta) REFERENCES public.t_detail_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_invoice_kta t_invoice_kta_id_detail_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_invoice_kta
    ADD CONSTRAINT t_invoice_kta_id_detail_kta_foreign FOREIGN KEY (id_detail_kta) REFERENCES public.t_detail_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_kta t_kta_id_dp_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_kta
    ADD CONSTRAINT t_kta_id_dp_foreign FOREIGN KEY (id_dp) REFERENCES public.t_dp(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_kta t_kta_id_registrasi_users_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_kta
    ADD CONSTRAINT t_kta_id_registrasi_users_foreign FOREIGN KEY (id_registrasi_users) REFERENCES public.t_registrasi_users(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_legalitas_kta t_legalitas_kta_id_detail_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_legalitas_kta
    ADD CONSTRAINT t_legalitas_kta_id_detail_kta_foreign FOREIGN KEY (id_detail_kta) REFERENCES public.t_detail_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_payment_confirmation t_payment_confirmation_id_invoice_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_payment_confirmation
    ADD CONSTRAINT t_payment_confirmation_id_invoice_kta_foreign FOREIGN KEY (id_invoice_kta) REFERENCES public.t_invoice_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_pemberhentian_agt t_pemberhentian_agt_id_detail_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_pemberhentian_agt
    ADD CONSTRAINT t_pemberhentian_agt_id_detail_kta_foreign FOREIGN KEY (id_detail_kta) REFERENCES public.t_detail_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_pj_kta t_pj_kta_id_detail_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_pj_kta
    ADD CONSTRAINT t_pj_kta_id_detail_kta_foreign FOREIGN KEY (id_detail_kta) REFERENCES public.t_detail_kta(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_role_share_confirmation t_role_share_confirmation_id_invoice_kta_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_role_share_confirmation
    ADD CONSTRAINT t_role_share_confirmation_id_invoice_kta_foreign FOREIGN KEY (id_invoice_role_share) REFERENCES public.t_invoice_role_share(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- Name: t_role_share_confirmation t_role_share_confirmation_id_role_share_accumulation_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_role_share_confirmation
    ADD CONSTRAINT t_role_share_confirmation_id_role_share_accumulation_foreign FOREIGN KEY (id_role_share_accumulation) REFERENCES public.t_role_share_accumulation(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: t_users_dp t_users_dp_id_dp_foreign; Type: FK CONSTRAINT; Schema: public; Owner: zero
--

ALTER TABLE ONLY public.t_users_dp
    ADD CONSTRAINT t_users_dp_id_dp_foreign FOREIGN KEY (id_dp) REFERENCES public.t_dp(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

