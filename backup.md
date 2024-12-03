openssl genpkey -algorithm RSA -out agent2-key.pem
openssl req -new -x509 -key agent2-key.pem -out agent2-cert.pem -days 365