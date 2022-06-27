```mermaid
classDiagram

    User "1..*" o-- "0..*" Playlist
    Song "1..*" --o "0..*" Playlist

    class User{
        +id_user
        +username
        +password
    }

    class Playlist{
        +id_playlist
        +id_user
        +title
        +description
    }

    class Song{
        +id_song
        +id_playlist
        +path
        +title
        +author
        +album
        +description
        +tag
    }

```