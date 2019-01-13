#MultiSend
###Requirements:
+ [SMTP Authentication Support](https://www.drupal.org/project/smtp)
###What This Module Does.
This module allows users to send the data from three pages to multiple recipients. 

#How to Use This Module.
###Configuration
In the Drupal admin dashboard, go to...

`Configuration > System > Multisend Module Settings`

From there, you will configure your SMTP settings.

###Adding the Forms to Your Theme

This module includes three routes that lead to a contact form. These should be used only in the corresponding templates.
####1. Share Attorney
`node--attorney--full.html.twig`

`<a href="/share/attorneys/{{ node.id }}"></a>`

####2. Share Practice Area
`single practice area page `

`node--practice-area--full.html.twig (future template)`

`<a href="/share/practice-area/{{ node.id }}"></a>`

####3. Share All Practice Areas

`all practice areas page`

`node--all-practice-areas.html.twig (future template)`

`<a href="/share/practice-areas"></a>`
