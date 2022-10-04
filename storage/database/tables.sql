-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           PostgreSQL 14.5, compiled by Visual C++ build 1914, 64-bit
-- OS do Servidor:               
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES  */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Database: sales

-- DROP DATABASE IF EXISTS sales;

-- CREATE DATABASE sale
    -- WITH
    -- OWNER = postgres
    -- ENCODING = 'UTF8'
    -- LC_COLLATE = 'Portuguese_Brazil.1252'
    -- LC_CTYPE = 'Portuguese_Brazil.1252'
    -- TABLESPACE = pg_default
    -- CONNECTION LIMIT = -1
    -- IS_TEMPLATE = False;

-- Copiando estrutura para tabela public.product_types
CREATE TABLE IF NOT EXISTS "product_types" (
	"product_type_id"  SERIAL NOT NULL,
	"description" TEXT NOT NULL,
	"status" SMALLINT NOT NULL DEFAULT '1',
	PRIMARY KEY ("product_type_id")
);

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela public.products
CREATE TABLE IF NOT EXISTS "products" (
	"product_id" SERIAL NOT NULL,
	"product_type_id" INTEGER NOT NULL,
	"description" TEXT NOT NULL,
	"unit_price" REAL NOT NULL,
	"status" SMALLINT NOT NULL DEFAULT '1',
	PRIMARY KEY ("product_id"),
	CONSTRAINT "fk_product_types_pr" FOREIGN KEY ("product_type_id") REFERENCES "product_types" ("product_type_id") ON UPDATE NO ACTION ON DELETE NO ACTION
);

-- Exportação de dados foi desmarcado.


-- Copiando estrutura para tabela public.taxe_product_types
CREATE TABLE IF NOT EXISTS "taxe_product_types" (
	"taxe_product_type_id" SERIAL NOT NULL,
	"product_type_id" INTEGER NOT NULL,
	"taxe_type" TEXT NOT NULL,
	"unit_percentage" REAL NOT NULL,
	"status" SMALLINT NOT NULL DEFAULT '1',
	PRIMARY KEY ("taxe_product_type_id"),
	CONSTRAINT "fk_product_types" FOREIGN KEY ("product_type_id") REFERENCES "product_types" ("product_type_id") ON UPDATE NO ACTION ON DELETE NO ACTION
);
-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela public.sales
CREATE TABLE IF NOT EXISTS "sales" (
	"sale_id" SERIAL NOT NULL,
	"description" TEXT NOT NULL,
	"total_price" REAL NOT NULL,
	"total_taxes" REAL NOT NULL,
	"status" SMALLINT NOT NULL DEFAULT '1',
	PRIMARY KEY ("sale_id")
);

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela public.sale_products
CREATE TABLE IF NOT EXISTS "sale_products" (
	"sale_product_id" SERIAL NOT NULL,
	"sale_id" INTEGER NOT NULL,
	"product_id" INTEGER NOT NULL,
	"unit_price" REAL NOT NULL,
	"unit_price_tax" REAL  NOT NULL,
	"quantity" SMALLINT NOT NULL DEFAULT '0',
	"description" TEXT NOT NULL DEFAULT '',
	"total_price" REAL NOT NULL,
	"total_price_tax" REAL NOT NULL,
	"status" SMALLINT NOT NULL DEFAULT '1',
	PRIMARY KEY ("sale_product_id"),
	CONSTRAINT "fk_sale_id" FOREIGN KEY ("sale_id") REFERENCES "sales" ("sale_id") ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT "fk_sale_product_id" FOREIGN KEY ("product_id") REFERENCES "products" ("product_id") ON UPDATE NO ACTION ON DELETE NO ACTION
);

-- Exportação de dados foi desmarcado.




CREATE VIEW "V_PRODUCTS" AS  SELECT tb.product_id,
    tb.product_type_id,
    tb.description,
    tb.unit_price,
    tb.status,
    pt.description AS product_type_desc
   FROM (products tb
     JOIN product_types pt ON ((pt.product_type_id = tb.product_type_id)))
  WHERE ((tb.status = '1'::smallint) AND (pt.status = '1'::smallint));;

-- Copiando estrutura para view public.V_SALES_PRODUCTS
-- Removendo tabela temporária e criando a estrutura VIEW final
CREATE VIEW "V_SALES_PRODUCTS" AS  SELECT sp.sale_id,
    sp.sale_product_id,
    sp.unit_price,
    sp.unit_price_tax,
    sp.quantity,
    sp.total_price,
    sp.total_price_tax,
    sp.description,
    pr.product_id,
    pr.description AS product_desc
   FROM (sale_products sp
     JOIN products pr ON ((pr.product_id = sp.product_id)))
  WHERE ((sp.status = 1) AND (pr.status = 1))
  ORDER BY sp.sale_id DESC;;

-- Copiando estrutura para view public.V_TAXES
-- Removendo tabela temporária e criando a estrutura VIEW final
CREATE VIEW "V_TAXES" AS  SELECT tb.taxe_product_type_id,
    tb.product_type_id,
    tb.taxe_type,
    tb.unit_percentage,
    tb.status,
    pt.description AS product_type_desc
   FROM (taxe_product_types tb
     JOIN product_types pt ON ((pt.product_type_id = tb.product_type_id)))
  WHERE ((tb.status = '1'::smallint) AND (pt.status = '1'::smallint));;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
