/*==============================================================*/
/* DBMS name:      PostgreSQL 9.x                               */
/* Created on:     8/8/2018 5:32:33 PM                          */
/*==============================================================*/


drop table ATTEND;

drop table BKRECORD;

drop table CANDIDATE;

drop table CAND_RATE;

drop table CATEGORY;

drop table COLLECT;

drop table CRECORD;

drop table DAILY;

drop table DAILY_RATE;

drop table DIRECTOR;

drop table HISTORY;

drop table HOLDER;

drop table INDEXRECORD;

drop table INSPECT;

drop table MESSAGE;

drop table SIGN;

drop table STOCKACTION;

drop table STOCKRECORD;

drop table WAVERECORD;

drop table WEAK;

/*==============================================================*/
/* Table: ATTEND                                                */
/*==============================================================*/
create table ATTEND (
   ID                   SERIAL               not null,
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   "TIME"               TIMESTAMP            null,
   constraint PK_ATTEND primary key (ID)
);

/*==============================================================*/
/* Table: BKRECORD                                              */
/*==============================================================*/
create table BKRECORD (
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   INCREASE             FLOAT4               null,
   DATE                 DATE                 null,
   "TIME"               TIMESTAMP            null,
   constraint PK_BKRECORD primary key (CODE)
);

/*==============================================================*/
/* Table: CANDIDATE                                             */
/*==============================================================*/
create table CANDIDATE (
   ID                   SERIAL               not null,
   PREFLIST             VARCHAR(32000)       null,
   "TIME"               TIMESTAMP            null,
   constraint PK_CANDIDATE primary key (ID)
);

/*==============================================================*/
/* Table: CAND_RATE                                             */
/*==============================================================*/
create table CAND_RATE (
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   CURRENT              FLOAT4               null,
   A                    FLOAT4               null,
   B                    FLOAT4               null,
   R                    FLOAT4               null,
   INCREASE             FLOAT4               null,
   "TIME"               TIMESTAMP            null
);

/*==============================================================*/
/* Table: CATEGORY                                              */
/*==============================================================*/
create table CATEGORY (
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   TYPE                 VARCHAR(8)           null,
   CONTENT              VARCHAR(1024)        null,
   constraint PK_CATEGORY primary key (CODE)
);

/*==============================================================*/
/* Table: COLLECT                                               */
/*==============================================================*/
create table COLLECT (
   ID                   SERIAL               not null,
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   DATE                 DATE                 null,
   FLAG                 BOOL                 null,
   constraint PK_COLLECT primary key (ID)
);

/*==============================================================*/
/* Table: CRECORD                                               */
/*==============================================================*/
create table CRECORD (
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   INCREASE             FLOAT4               null,
   DATE                 DATE                 null,
   "TIME"               TIMESTAMP            null
);

/*==============================================================*/
/* Table: DAILY                                                 */
/*==============================================================*/
create table DAILY (
   CODE                 VARCHAR(8)           not null,
   OPEN                 FLOAT4               null,
   CURRENT              FLOAT4               null,
   HIGH                 FLOAT4               null,
   LOW                  FLOAT4               null,
   CLMN                 FLOAT4               null,
   DATE                 DATE                 null
);

/*==============================================================*/
/* Table: DAILY_RATE                                            */
/*==============================================================*/
create table DAILY_RATE (
   CODE                 VARCHAR(8)           not null,
   A                    FLOAT4               not null,
   B                    FLOAT4               null,
   R                    FLOAT4               null,
   DATE                 DATE                 null
);

/*==============================================================*/
/* Table: DIRECTOR                                              */
/*==============================================================*/
create table DIRECTOR (
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   "TIME"               TIMESTAMP            null,
   PRICE                FLOAT4               null,
   TYPE                 VARCHAR(2)           null,
   LEVEL                INT4                 null,
   TOTAL                INT4                 null,
   ARROW                VARCHAR(2)           null,
   constraint PK_DIRECTOR primary key (CODE)
);

/*==============================================================*/
/* Table: HISTORY                                               */
/*==============================================================*/
create table HISTORY (
   FTIME                TIMESTAMP            null,
   LTIME                TIMESTAMP            null,
   RECORD               VARCHAR(4096)        null,
   TYPE                 VARCHAR(2)           null
);

/*==============================================================*/
/* Table: HOLDER                                                */
/*==============================================================*/
create table HOLDER (
   ID                   SERIAL               not null,
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   "TIME"               TIMESTAMP            null,
   constraint PK_HOLDER primary key (ID)
);

/*==============================================================*/
/* Table: INDEXRECORD                                           */
/*==============================================================*/
create table INDEXRECORD (
   CODE                 VARCHAR(8)           not null,
   DATE                 DATE                 null,
   "TIME"               TIMESTAMP            null,
   NAME                 VARCHAR(8)           null,
   CLOSE                FLOAT4               null,
   OPEN                 FLOAT4               null,
   CURRENT              FLOAT4               null,
   HIGH                 FLOAT4               null,
   LOW                  FLOAT4               null,
   CLMN                 FLOAT4               null,
   MONEY                FLOAT4               null,
   AVG                  FLOAT4               null
);

/*==============================================================*/
/* Table: INSPECT                                               */
/*==============================================================*/
create table INSPECT (
   ID                   SERIAL               not null,
   CODE                 VARCHAR(8)           null,
   NAME                 VARCHAR(8)           null,
   TYPE                 VARCHAR(2)           null,
   OPT                  VARCHAR(2)           null,
   VALUE                FLOAT4               null,
   CREATE_DATE          TIMESTAMP            null,
   FLAG                 BOOL                 null,
   constraint PK_INSPECT primary key (ID)
);

/*==============================================================*/
/* Table: MESSAGE                                               */
/*==============================================================*/
create table MESSAGE (
   ID                   SERIAL               not null,
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   MESSAGE              VARCHAR(1024)        null,
   FLAG                 BOOL                 null,
   "TIME"               TIMESTAMP            null,
   constraint PK_MESSAGE primary key (ID)
);

/*==============================================================*/
/* Table: SIGN                                                  */
/*==============================================================*/
create table SIGN (
   CODE                 VARCHAR(8)           not null,
   BUY                  CHAR(10)             null,
   SELL                 CHAR(10)             null
);

/*==============================================================*/
/* Table: STOCKACTION                                           */
/*==============================================================*/
create table STOCKACTION (
   ACTION               INT4                 null,
   "TIME"               TIMESTAMP            null,
   FTIME                TIMESTAMP            null,
   LTIME                TIMESTAMP            null,
   QUEUE                jsonb                null,
   GW                   jsonb                null,
   TYPE                 VARCHAR(1)           null,
   CONTENT              VARCHAR(4096)        null,
   DETAIL               VARCHAR(4096)        null,
   ARROW                VARCHAR(8)           null,
   PREF                 VARCHAR(4096)        null,
   PREF1                VARCHAR(4096)        null,
   STRONG               FLOAT4               null,
   DEX                  FLOAT4               null
);

/*==============================================================*/
/* Table: STOCKRECORD                                           */
/*==============================================================*/
create table STOCKRECORD (
   CODE                 VARCHAR(8)           not null,
   DATE                 DATE                 null,
   "TIME"               TIMESTAMP            null,
   NAME                 VARCHAR(8)           null,
   CLOSE                FLOAT4               null,
   OPEN                 FLOAT4               null,
   CURRENT              FLOAT4               null,
   HIGH                 FLOAT4               null,
   LOW                  FLOAT4               null,
   CLMN                 FLOAT4               null,
   MONEY                FLOAT4               null,
   AVG                  FLOAT4               null
);

/*==============================================================*/
/* Table: WAVERECORD                                            */
/*==============================================================*/
create table WAVERECORD (
   CODE                 VARCHAR(8)           not null,
   DT                   DATE                 null,
   WV                   jsonb                null,
   GW                   jsonb                null
);

/*==============================================================*/
/* Table: WEAK                                                  */
/*==============================================================*/
create table WEAK (
   ID                   SERIAL               not null,
   CODE                 VARCHAR(8)           not null,
   NAME                 VARCHAR(8)           null,
   "TIME"               TIMESTAMP            null,
   constraint PK_WEAK primary key (ID)
);

