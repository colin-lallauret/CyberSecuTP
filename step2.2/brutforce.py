import time
start_time = time.time()

mdp = '9999'

allChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'

mdpFoundBool = False
mdpFound = ""

def write():
  print('Mot de passe trouvé ? (True / False) ', mdpFoundBool)
  print('Le mot de passe : ', mdpFound)
  print("--- %s seconds ---" % (time.time() - start_time))
  exit(1)

while(mdpFoundBool == False):
    for a in range(len(allChars)):
        print(allChars[a])
        if mdp == allChars[a]:
            mdpFoundBool = True
            mdpFound = allChars[a]
            write()
        for b in range(len(allChars)):
            print(allChars[b])
            if mdp == allChars[a] + allChars[b]:
                mdpFoundBool = True
                mdpFound = allChars[a] + allChars[b]
                write()
            for c in range(len(allChars)):
                if mdp == allChars[a] + allChars[b] + allChars[c]:
                    mdpFoundBool = True
                    mdpFound = allChars[a] + allChars[b] + allChars[c]
                    write()
                for d in range(len(allChars)):
                    if mdp == allChars[a] + allChars[b] + allChars[c] + allChars[d]:
                        mdpFoundBool = True
                        mdpFound = allChars[a] + allChars[b] + allChars[c] + allChars[d]
                        write()
