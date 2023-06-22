'
' SLMSAY
' by @pidg
'
'
'            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
'                    Version 2, December 2004
'
' Copyright (C) 2004 Sam Hocevar
' 14 rue de Plaisance, 75014 Paris, France
' Everyone is permitted to copy and distribute verbatim or modified
' copies of this license document, and changing it is allowed as long
' as the name is changed.
'
'            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
'   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
'
'  0. You just DO WHAT THE FUCK YOU WANT TO. 
'

dim version As string = "0.21"

public Function Replace(intext As string, replacewhat As string, replacewith As string) As string
     
     dim ii As integer
     
     For ii = Len(intext) to 1 step -1
          If mid(intext,ii,Len(replacewhat)) = replacewhat Then
               intext=left(intext,ii-1) & replacewith & right(intext,Len(intext)-(ii-1+Len(replacewhat)))
               ii=ii-Len(replacewith)+1
          EndIf     
     Next
          
     replace=intext

End Function



'Create the charset
dim CharsDat(172) As string
    
CharsDat(32) = "......,......,......,......,......"
CharsDat(33) = "#,#,#,.,#"
CharsDat(34) = "#..#,....,....,....,...."
CharsDat(35) = ".#..#.,######,.#..#.,######,.#..#."
CharsDat(36) = ".#####,#.##..,.####.,..##.#,#####."
CharsDat(37) = "#...#,...#.,..#..,.#...,#...#"
CharsDat(38) = ".###..,#...#.,.###..,#...##,.#####"
CharsDat(39) = "#,.,.,.,."
CharsDat(40) = ".#,#.,#.,#.,.#"
CharsDat(41) = "#.,.#,.#,.#,#."
CharsDat(42) = "#.#.#,.###.,#####,.###.,#.#.#"
CharsDat(43) = "...,.#.,###,.#.,..."
CharsDat(44) = "..,..,..,.#,#."
CharsDat(45) = "....,....,####,....,...."
CharsDat(46) = ".,.,.,.,#"
CharsDat(47) = "....#,...#.,..#..,.#...,#...."
CharsDat(48) = ".###.,##.##,##.##,##.##,.###."
CharsDat(49) = ".##.,###.,.##.,.##.,####"
CharsDat(50) = ".####.,#...##,..###.,.##...,######"
CharsDat(51) = "#####.,...###,.####.,...###,#####."
CharsDat(52) = "..###.,.#.##.,#..##.,######,...##."
CharsDat(53) = "######,##....,#####.,....##,#####."
CharsDat(54) = ".####.,##....,#####.,##..##,.####."
CharsDat(55) = "######,....##,...##.,..##..,.##..."
CharsDat(56) = ".####.,##..##,.####.,##..##,.####."
CharsDat(57) = ".####.,##..##,.#####,....##,.####."
CharsDat(58) = ".,#,.,#,."
CharsDat(59) = "..,.#,..,.#,#."
CharsDat(60) = "..#,.#.,#..,.#.,..#"
CharsDat(61) = "....,####,....,####,...."
CharsDat(62) = "#..,.#.,..#,.#.,#.."
CharsDat(63) = ".####.,#....#,..###.,......,..#..."
CharsDat(64) = ".#####,#.###.,#.#..#,#..#.#,.####."
CharsDat(65) = ".####.,##..##,######,##..##,##..##"
CharsDat(66) = "#####.,##..##,#####.,##..##,#####."
CharsDat(67) = ".#####,##....,##....,##....,.#####"
CharsDat(68) = "#####.,##..##,##..##,##..##,#####."
CharsDat(69) = "######,##....,######,##....,######"
CharsDat(70) = "######,##....,######,##....,##...."
CharsDat(71) = ".#####,##....,##.###,##..##,.#####"
CharsDat(72) = "##..##,##..##,######,##..##,##..##"
CharsDat(73) = "######,..##..,..##..,..##..,######"
CharsDat(74) = ".######,...##..,...##..,##.##..,.###..."
CharsDat(75) = "##..##,##.##.,####..,##.##.,##..##"
CharsDat(76) = "##....,##....,##....,##....,######"
CharsDat(77) = "##....##,###..###,##.##.##,##....##,##....##"
CharsDat(78) = "###...##,####..##,##.##.##,##..####,##...###"
CharsDat(79) = ".#####.,##...##,##...##,##...##,.#####."
CharsDat(80) = "#####.,##..##,#####.,##....,##...."
CharsDat(81) = ".####.,##..##,##..##,##.###,.#####"
CharsDat(82) = "#####.,##..##,#####.,##..##,##..##"
CharsDat(83) = ".#####,##....,.####.,....##,#####."
CharsDat(84) = "######,..##..,..##..,..##..,..##.."
CharsDat(85) = "##..##,##..##,##..##,##..##,.####."
CharsDat(86) = "##....##,##....##,.##..##.,.##..##.,...##..."
CharsDat(87) = "##....##,##....##,##.##.##,###..###,##....##"
CharsDat(88) = "##...##,.##.##.,..###..,.##.##.,##...##"
CharsDat(89) = "##..##,##..##,.####.,..##..,..##.."
CharsDat(90) = "######,...##.,..##..,.##...,######"
CharsDat(91) = "##,#.,#.,#.,##"
CharsDat(92) = "#....,.#...,..#..,...#.,....#"
CharsDat(93) = "##,.#,.#,.#,##"
CharsDat(94) = ".#.,#.#,...,...,..."
CharsDat(95) = "......,......,......,......,######"
CharsDat(96) = "#.,.#,..,..,.."
CharsDat(123) = "..#,.#.,##.,.#.,..#"
CharsDat(124) = "#,#,#,#,#"
CharsDat(125) = "#..,.#.,.##,.#.,#.."
CharsDat(126) = ".....,.#...,#.#.#,...#.,....."
CharsDat(163) = "..###.,.#...#,####..,.#....,######"
CharsDat(172) = "......,......,######,.....#,......"


'Let's define some variables!!!

dim fore As integer=0, back As integer=1, multi As integer=0, shadow As integer=0, rainbow As integer=0

dim cc As string = Chr(3), c As string = trim(ucase(command))

dim slm() As string, tempslm() As string
ReDim SLM(0)            'slm() will store our completed figure
ReDim TempSLM(0)        'tempslm() used for shifting stuff around in

dim n As integer, j As string, char As string, h As integer         'Various variables for incrementing and string
dim i As integer, charWidth As integer, charHeight As integer       'operations

dim currentChar As string, total As string
dim removedChar As string                                       'Used in command line switches

dim LastColour As integer = 0, ThisColour As integer = 0        'Used in multicolour operations

dim ch() As string          'Stores each line of an individual character when parsing
ReDim ch(0)






'Check for command line options

If c ="" Then

    Print "slmsay: missing parameter"
    Print "Try slmsay --help for more information."

ElseIf c = "--HELP" Then

    Print "Usage: slmsay [OPTIONS] text"
    Print "Outputs IRC banner text."
    Print
    Print " -m       multicoloured"
    Print " -s       add shadow  COMING SOON"
    Print " -g       rainbow colours  COMING SOON"
    Print
    Print
    Print "v" & version & " https://github.com/pidg/slmsay/"
    Print ""
    
Else






' Remove switches from command line and set them

dim All As string, switched As integer
    
    dim original As string
    
    total=""

    For n = 1 to Len(c)+1

        If n<=Len(c) Then j=mid(c,n,1)
        
        If j=" " Or n=Len(c)+1 Then
       
            If left(total,1)="/" Or left(total,1)="-" Then 

                switched=0
                original = total
                total = mid(total,2,Len(total))
                
                Select Case left(total,1)
                
                    Case "M"
                        multi=1
                        switched=1

                    Case "G"
                        rainbow=1
                        switched=1                        
                    

                End Select                
                
                
                If switched Then total="" Else total=original
            
            EndIf

            all = trim(all & " " & total)
            total=""
            j=""
        EndIf

        total = total & j  

    Next






c = trim(all & " " & total)

' Create SLM figure

    randomize

    For n = 1 to Len(c)


        If multi=1 Then
        
            lastcolour=thiscolour
                
            dim mmm As integer = 0
                    
            Do
                mmm = int(Rnd * 6) + 1
                            
                'The following colours are the lighter
                'ones of the set (so we can have shadows
                'when applying 3D/shadow effects):
                            
                Select Case mmm
                    Case 1: thiscolour = 4
                    Case 2: thiscolour = 8
                    Case 3: thiscolour = 9
                    Case 4: thiscolour = 11
                    Case 5: thiscolour = 12
                    Case 6: thiscolour = 13
                End Select
                    
            loop Until thiscolour <> lastcolour And thiscolour <> back         'Make sure they're different, and
                                                                          'also not the same as background
        
        Else
        
                thiscolour = fore
        
        EndIf
        
        
        
        'Split into individual characters from command line string
        j = mid(c,n,1)
        
        'Load character shape from array
        char=charsdat(asc(j))
        
        ' Get width and height of this character:
        charwidth = instr(char, ",")-1
        charheight=1
        
        ReDim ch(0)     ' To store the current character in
        

        
        For i = 1 to Len(char)
        
            j = mid(char,i,1)
       
            If j = "#" Then j = Chr(thiscolour + 65)
        
            
            If j = "," Then 
                ReDim preserve ch(ubound(ch)+1)
                charheight=charheight+1
                j=""
            EndIf
    
       
            
            ch(ubound(ch)) = ch(ubound(ch)) & j
        
        Next
        
        
        If charheight > ubound(slm) Then
    
            'Store current figure in temp array        
            ReDim tempslm(ubound(slm))
            
            For n = 0 to ubound(slm)
                tempslm(n)=slm(n)        
            Next
            
                  
            
            'Move current figure to baseline
           
            ReDim preserve slm(charheight)
    
    
            For h = ubound(tempslm) to 0 step -1
            
                slm(ubound(slm)-ubound(tempslm)+h) = tempslm(h)
                    
            Next
            
        EndIf
    
    
        'Add this letter to figure
        
        For h = ubound(ch) to 0 step -1        
    
            slm(ubound(slm)-ubound(ch)+h) = slm(ubound(slm)-ubound(ch)+h) & "." & ch(h)
        
        Next
    
        
    Next       
    
    
    For n = 0 to ubound(slm)
    
        total="": currentchar=""
        slm(n)=trim(slm(n))
    
        For h = 1 to Len(slm(n))
        
            j=mid(slm(n),h,1)
            
            If j<>currentchar Then
            
                'Change colour
        
                currentchar=j
                            
                If j="." Then
                
                    total = total & cc & trim(str(back)) & "," & trim(str(back))
                
                Else
                
                    total = total & cc & trim(str(asc(j)-65)) & "," & trim(str(asc(j)-65))
                
                EndIf
            
            EndIf
    
        total = total & "o"
        
        Next
    
        If total <> "" Then Print Chr(2) & Chr(2)  & total
    
    
    Next


    
EndIf

