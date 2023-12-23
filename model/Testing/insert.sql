"""for login"""
INSERT INTO dbUser(username, pass, email)values('Test User', crypt('pass123', gen_salt('md5')), testemail@gmail.com)