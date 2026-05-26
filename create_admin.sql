-- Cree (ou recree) le compte administrateur
-- Identifiant : Admin
-- Mot de passe : AdminAdmin  (hache en bcrypt, a changer apres connexion)
--
-- Usage sur le VPS (SQLite) :
--   sqlite3 data/products.db < create_admin.sql
--
-- Le hash ci-dessous est genere par PHP password_hash(..., PASSWORD_DEFAULT).

-- Au cas ou un compte "Admin" existerait deja, on le supprime d'abord.
DELETE FROM admins WHERE username = 'Admin';

INSERT INTO admins (username, password_hash)
VALUES ('Admin', '$2y$10$cZ82iWfebLeDlszM6XbzH.36XuZQlSyFxRnr1HgfAXnZUeOY0EPDm');
