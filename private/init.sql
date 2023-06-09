USE [mirea_videohost_5]
GO
/****** Object:  Table [dbo].[S_EventType]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[S_EventType](
	[ID_EventType] [tinyint] NOT NULL,
	[Caption] [varchar](16) NOT NULL,
 CONSTRAINT [PK_S_EventType] PRIMARY KEY CLUSTERED 
(
	[ID_EventType] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[S_Role]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[S_Role](
	[ID_Role] [tinyint] NOT NULL,
	[Caption] [varchar](16) NOT NULL,
 CONSTRAINT [PK_S_Role] PRIMARY KEY CLUSTERED 
(
	[ID_Role] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_Comment]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_Comment](
	[ID_Comment] [int] IDENTITY(1,1) NOT NULL,
	[ID_User] [int] NOT NULL,
	[ID_Video] [int] NOT NULL,
	[Text] [varchar](255) NOT NULL,
 CONSTRAINT [PK_T_Comment] PRIMARY KEY CLUSTERED 
(
	[ID_Comment] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_Log]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_Log](
	[ID_Log] [int] IDENTITY(1,1) NOT NULL,
	[ID_EventType] [tinyint] NOT NULL,
	[ID_User] [int] NOT NULL,
	[ID_Video] [int] NULL,
	[ID_Comment] [int] NULL,
	[ID_Playlist] [int] NULL,
	[Time] [datetime] NOT NULL,
 CONSTRAINT [PK_T_Log] PRIMARY KEY CLUSTERED 
(
	[ID_Log] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[T_Playlist]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_Playlist](
	[ID_Playlist] [int] IDENTITY(1,1) NOT NULL,
	[ID_User] [int] NOT NULL,
	[Name] [varchar](255) NOT NULL,
 CONSTRAINT [PK_T_Playlist] PRIMARY KEY CLUSTERED 
(
	[ID_Playlist] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_PlaylistEntry]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[T_PlaylistEntry](
	[ID_PlaylistEntry] [int] IDENTITY(1,1) NOT NULL,
	[ID_Playlist] [int] NOT NULL,
	[ID_Video] [int] NOT NULL,
 CONSTRAINT [PK_T_PlaylistEntry] PRIMARY KEY CLUSTERED 
(
	[ID_PlaylistEntry] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[T_Token]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_Token](
	[ID_Token] [int] IDENTITY(1,1) NOT NULL,
	[ID_User] [int] NOT NULL,
	[Value] [char](32) NOT NULL,
	[Expires] [datetime] NOT NULL,
	[IP] [binary](4) NOT NULL,
 CONSTRAINT [PK_T_Token] PRIMARY KEY CLUSTERED 
(
	[ID_Token] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_User]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_User](
	[ID_User] [int] IDENTITY(1,1) NOT NULL,
	[ID_Role] [tinyint] NOT NULL,
	[Login] [varchar](32) NOT NULL,
	[PasswordHash] [varchar](32) NOT NULL,
	[Name] [varchar](64) NOT NULL,
	[Info] [varchar](255) NOT NULL,
	[Locale] [varchar](8) NOT NULL,
	[Theme] [varchar](8) NOT NULL,
 CONSTRAINT [PK_T_User] PRIMARY KEY CLUSTERED 
(
	[ID_User] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[T_Video]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[T_Video](
	[ID_Video] [int] IDENTITY(1,1) NOT NULL,
	[ID_User] [int] NOT NULL,
	[Name] [varchar](255) NOT NULL,
	[Duration] [int] NOT NULL,
	[Is_Public] [bit] NOT NULL,
	[Alias] [varchar](8) NOT NULL,
	[Path_override] [varchar](255) NULL,
 CONSTRAINT [PK_T_Video] PRIMARY KEY CLUSTERED 
(
	[ID_Video] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
ALTER TABLE [dbo].[T_Log] ADD  CONSTRAINT [DF_T_Log_Time]  DEFAULT (getdate()) FOR [Time]
GO
ALTER TABLE [dbo].[T_Token] ADD  CONSTRAINT [DF_T_Token_IP]  DEFAULT (CONVERT([binary](4),'0x00000000',(1))) FOR [IP]
GO
ALTER TABLE [dbo].[T_User] ADD  CONSTRAINT [DF_T_User_Locale]  DEFAULT ('ru') FOR [Locale]
GO
ALTER TABLE [dbo].[T_User] ADD  CONSTRAINT [DF_T_User_Theme]  DEFAULT ('dark') FOR [Theme]
GO
ALTER TABLE [dbo].[T_Comment]  WITH CHECK ADD  CONSTRAINT [FK_T_Comment_T_User] FOREIGN KEY([ID_User])
REFERENCES [dbo].[T_User] ([ID_User])
GO
ALTER TABLE [dbo].[T_Comment] CHECK CONSTRAINT [FK_T_Comment_T_User]
GO
ALTER TABLE [dbo].[T_Comment]  WITH CHECK ADD  CONSTRAINT [FK_T_Comment_T_Video] FOREIGN KEY([ID_Video])
REFERENCES [dbo].[T_Video] ([ID_Video])
GO
ALTER TABLE [dbo].[T_Comment] CHECK CONSTRAINT [FK_T_Comment_T_Video]
GO
ALTER TABLE [dbo].[T_Log]  WITH CHECK ADD  CONSTRAINT [FK_T_Log_S_EventType] FOREIGN KEY([ID_EventType])
REFERENCES [dbo].[S_EventType] ([ID_EventType])
GO
ALTER TABLE [dbo].[T_Log] CHECK CONSTRAINT [FK_T_Log_S_EventType]
GO
ALTER TABLE [dbo].[T_Log]  WITH NOCHECK ADD  CONSTRAINT [FK_T_Log_T_Comment] FOREIGN KEY([ID_Comment])
REFERENCES [dbo].[T_Comment] ([ID_Comment])
GO
ALTER TABLE [dbo].[T_Log] NOCHECK CONSTRAINT [FK_T_Log_T_Comment]
GO
ALTER TABLE [dbo].[T_Log]  WITH NOCHECK ADD  CONSTRAINT [FK_T_Log_T_Playlist] FOREIGN KEY([ID_Playlist])
REFERENCES [dbo].[T_Playlist] ([ID_Playlist])
GO
ALTER TABLE [dbo].[T_Log] NOCHECK CONSTRAINT [FK_T_Log_T_Playlist]
GO
ALTER TABLE [dbo].[T_Log]  WITH CHECK ADD  CONSTRAINT [FK_T_Log_T_User] FOREIGN KEY([ID_User])
REFERENCES [dbo].[T_User] ([ID_User])
GO
ALTER TABLE [dbo].[T_Log] CHECK CONSTRAINT [FK_T_Log_T_User]
GO
ALTER TABLE [dbo].[T_Log]  WITH NOCHECK ADD  CONSTRAINT [FK_T_Log_T_Video] FOREIGN KEY([ID_Video])
REFERENCES [dbo].[T_Video] ([ID_Video])
GO
ALTER TABLE [dbo].[T_Log] NOCHECK CONSTRAINT [FK_T_Log_T_Video]
GO
ALTER TABLE [dbo].[T_Playlist]  WITH CHECK ADD  CONSTRAINT [FK_T_Playlist_T_User] FOREIGN KEY([ID_User])
REFERENCES [dbo].[T_User] ([ID_User])
GO
ALTER TABLE [dbo].[T_Playlist] CHECK CONSTRAINT [FK_T_Playlist_T_User]
GO
ALTER TABLE [dbo].[T_PlaylistEntry]  WITH CHECK ADD  CONSTRAINT [FK_T_PlaylistEntry_T_Playlist] FOREIGN KEY([ID_Playlist])
REFERENCES [dbo].[T_Playlist] ([ID_Playlist])
GO
ALTER TABLE [dbo].[T_PlaylistEntry] CHECK CONSTRAINT [FK_T_PlaylistEntry_T_Playlist]
GO
ALTER TABLE [dbo].[T_PlaylistEntry]  WITH CHECK ADD  CONSTRAINT [FK_T_PlaylistEntry_T_Video] FOREIGN KEY([ID_Video])
REFERENCES [dbo].[T_Video] ([ID_Video])
GO
ALTER TABLE [dbo].[T_PlaylistEntry] CHECK CONSTRAINT [FK_T_PlaylistEntry_T_Video]
GO
ALTER TABLE [dbo].[T_Token]  WITH CHECK ADD  CONSTRAINT [FK_T_Token_T_User] FOREIGN KEY([ID_User])
REFERENCES [dbo].[T_User] ([ID_User])
GO
ALTER TABLE [dbo].[T_Token] CHECK CONSTRAINT [FK_T_Token_T_User]
GO
ALTER TABLE [dbo].[T_User]  WITH CHECK ADD  CONSTRAINT [FK_T_User_S_Role] FOREIGN KEY([ID_Role])
REFERENCES [dbo].[S_Role] ([ID_Role])
GO
ALTER TABLE [dbo].[T_User] CHECK CONSTRAINT [FK_T_User_S_Role]
GO
ALTER TABLE [dbo].[T_Video]  WITH CHECK ADD  CONSTRAINT [FK_T_Video_T_User] FOREIGN KEY([ID_User])
REFERENCES [dbo].[T_User] ([ID_User])
GO
ALTER TABLE [dbo].[T_Video] CHECK CONSTRAINT [FK_T_Video_T_User]
GO

GO
/****** Object:  Trigger [dbo].[TR_CommentDelete]    Script Date: 16.05.2023 9:49:22 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER TRIGGER [dbo].[TR_CommentDelete]
   ON [dbo].[T_Comment]
   AFTER DELETE
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Comment, ID_Video) SELECT 8, ID_User, ID_Comment, ID_Video FROM deleted
END
GO
/****** Object:  Trigger [dbo].[TR_CommentPost]    Script Date: 16.05.2023 9:54:01 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER TRIGGER [dbo].[TR_CommentPost]
   ON [dbo].[T_Comment]
   AFTER INSERT
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Comment, ID_Video) SELECT 7, ID_User, ID_Comment, ID_Video FROM inserted
END
GO
/****** Object:  Trigger [dbo].[TR_PlaylistCreate]    Script Date: 16.05.2023 9:54:32 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER TRIGGER [dbo].[TR_PlaylistCreate]
   ON  [dbo].[T_Playlist]
   AFTER INSERT
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Playlist) SELECT 9, ID_User, ID_Playlist FROM inserted
END
GO
/****** Object:  Trigger [dbo].[TR_PlaylistDelete]    Script Date: 16.05.2023 9:54:44 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER TRIGGER [dbo].[TR_PlaylistDelete]
   ON  [dbo].[T_Playlist]
   AFTER DELETE
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Playlist) SELECT 11, ID_User, ID_Playlist FROM deleted
END
GO
/****** Object:  Trigger [dbo].[TR_PlaylistEdit]    Script Date: 16.05.2023 9:54:58 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER TRIGGER [dbo].[TR_PlaylistEdit]
   ON  [dbo].[T_Playlist]
   AFTER UPDATE
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Playlist) SELECT 10, ID_User, ID_Playlist FROM inserted
END
GO
/****** Object:  Trigger [dbo].[TR_EntryAdd]    Script Date: 16.05.2023 9:55:09 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER TRIGGER [dbo].[TR_EntryAdd]
   ON [dbo].[T_PlaylistEntry]
   AFTER INSERT
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Playlist, ID_Video) 
	SELECT 13, T_Playlist.ID_User, inserted.ID_Playlist, inserted.ID_Video FROM inserted
	JOIN T_Playlist ON inserted.ID_Playlist = T_Playlist.ID_Playlist
END
GO
/****** Object:  Trigger [dbo].[TR_EntryRemove]    Script Date: 16.05.2023 9:55:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER TRIGGER [dbo].[TR_EntryRemove]
   ON [dbo].[T_PlaylistEntry]
   AFTER DELETE
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Playlist, ID_Video) 
	SELECT 14, T_Playlist.ID_User, deleted.ID_Playlist, deleted.ID_Video FROM deleted
	JOIN T_Playlist ON deleted.ID_Playlist = T_Playlist.ID_Playlist
END
GO
/****** Object:  Trigger [dbo].[TR_UserLogin]    Script Date: 16.05.2023 9:55:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER TRIGGER [dbo].[TR_UserLogin]
   ON [dbo].[T_Token]
   AFTER INSERT
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User) VALUES (1, (SELECT ID_User FROM inserted))
END
GO
/****** Object:  Trigger [dbo].[TR_UserLogout]    Script Date: 16.05.2023 9:55:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER TRIGGER [dbo].[TR_UserLogout]
   ON [dbo].[T_Token]
   AFTER UPDATE
AS 
BEGIN
	IF (SELECT Expires FROM inserted) <= GETDATE()
		INSERT INTO T_Log (ID_EventType, ID_User) VALUES (2, (SELECT ID_User FROM inserted))
END
GO
/****** Object:  Trigger [dbo].[TR_UserEdit]    Script Date: 16.05.2023 9:55:50 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER TRIGGER [dbo].[TR_UserEdit]
   ON  [dbo].[T_User]
   AFTER UPDATE
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User) SELECT 12, ID_User FROM inserted
END
GO
/****** Object:  Trigger [dbo].[TR_UserReg]    Script Date: 16.05.2023 9:56:00 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER TRIGGER [dbo].[TR_UserReg]
   ON  [dbo].[T_User]
   AFTER INSERT
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User) SELECT 6, ID_User FROM inserted
END
GO
/****** Object:  Trigger [dbo].[TR_AddVideo]    Script Date: 16.05.2023 9:56:11 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER TRIGGER [dbo].[TR_AddVideo]
   ON [dbo].[T_Video]
   AFTER INSERT
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Video) (SELECT 3, ID_User, ID_Video FROM inserted)
END
GO
/****** Object:  Trigger [dbo].[TR_EditVideo]    Script Date: 16.05.2023 9:56:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER TRIGGER [dbo].[TR_EditVideo]
   ON [dbo].[T_Video]
   AFTER UPDATE
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Video) (SELECT 4, ID_User, ID_Video FROM inserted)
END
GO
/****** Object:  Trigger [dbo].[TR_RemoveVideo]    Script Date: 16.05.2023 9:56:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER TRIGGER [dbo].[TR_RemoveVideo]
   ON [dbo].[T_Video]
   AFTER DELETE
AS 
BEGIN
	INSERT INTO T_Log (ID_EventType, ID_User, ID_Video) SELECT 5, ID_User, ID_Video FROM deleted
END


/****** Object:  StoredProcedure [dbo].[W_AddComment]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AddComment]
@userid int,
@alias varchar(8),
@text varchar(255)
AS
BEGIN
	IF EXISTS (
		SELECT TOP 1 T_Video.* 
		FROM T_Video
		LEFT JOIN T_User ON T_User.ID_User = @userid
		WHERE (T_Video.ID_User = @userid OR T_Video.Is_Public = 1 OR T_User.ID_Role = 1) AND T_Video.Alias = @alias COLLATE Latin1_General_CS_AS
	)
	BEGIN
		SELECT 0 [ERROR]
		INSERT INTO T_Comment (ID_User, ID_Video, Text) VALUES (@userid, (SELECT T_Video.ID_Video FROM T_Video WHERE T_Video.Alias = @alias COLLATE Latin1_General_CS_AS), @text)
	END
	ELSE
		SELECT 1 [ERROR]
END
GO
/****** Object:  StoredProcedure [dbo].[W_AddPlaylist]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AddPlaylist]
@userid int,
@name varchar(255)
AS
BEGIN
	IF EXISTS (SELECT * FROM T_Playlist WHERE Name LIKE @name AND ID_User = @userid)
		SELECT 1 [ERROR]
	ELSE
	BEGIN
		SELECT 0 [ERROR]
		INSERT INTO T_Playlist (ID_User, Name) VALUES (@userid, @name)
	END
END
GO
/****** Object:  StoredProcedure [dbo].[W_AddPlaylistEntry]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AddPlaylistEntry]
@userid int,
@plsid int,
@videoid int
AS
BEGIN
	IF EXISTS (
		SELECT * 
		FROM T_Playlist 
		LEFT JOIN T_User ON T_User.ID_User = @userid
		WHERE ID_Playlist = @plsid AND (T_Playlist.ID_User = @userid OR T_User.ID_Role = 1)
		)
	BEGIN
		SELECT 0 [ERROR]
		INSERT INTO T_PlaylistEntry (ID_Playlist, ID_Video) VALUES (@plsid, @videoid)
	END
	ELSE
		SELECT 1 [ERROR]
END
GO
/****** Object:  StoredProcedure [dbo].[W_AddVideo]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AddVideo]
@userid int,
@name varchar(255),
@dura int,
@pub bit,
@alias varchar(8)
AS
BEGIN
	INSERT INTO T_Video (ID_User, Name, Duration, Is_Public, Alias) Values (@userid, @name, @dura, @pub, @alias)
END
GO
/****** Object:  StoredProcedure [dbo].[W_AdminGetActiveSessions]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AdminGetActiveSessions]
@page int = 1,
@perpage int = 16
AS
BEGIN
	DECLARE @total int = (SELECT COUNT(*) FROM T_Token WHERE Expires > GETDATE());
	SELECT TOP (@perpage) *, @total [Total] FROM (
		SELECT T_Token.ID_Token [id], concat(
		convert(int, SUBSTRING(T_Token.IP, 1, 1)), '.',
		convert(int, SUBSTRING(T_Token.IP, 2, 1)), '.',
		convert(int, SUBSTRING(T_Token.IP, 3, 1)), '.',
		convert(int, SUBSTRING(T_Token.IP, 4, 1))
	) [ip], T_Token.Expires [expires], T_Token.ID_User [ID_User], T_User.Login [Login], ROW_NUMBER() OVER (ORDER BY T_User.ID_User) [num]
		FROM T_Token
		JOIN T_User ON T_Token.ID_User = T_User.ID_User
		WHERE Expires > GETDATE()
	) [tmp] WHERE tmp.num > (@page - 1) * @perpage
END
GO
/****** Object:  StoredProcedure [dbo].[W_AdminGetLog]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AdminGetLog]
@page int = 1,
@perpage int = 16
AS
BEGIN
	DECLARE @total int = (SELECT COUNT(*) FROM T_Log);
	SELECT TOP (@perpage) *, @total [Total] FROM (
		SELECT 
			T_Log.Time [Time], S_EventType.ID_EventType [Event.Id], 
			T_Log.ID_User [User.Id], T_User.Login [User.Login], 
			T_Log.ID_Video [Video.Id], T_Video.Alias [Video.Alias], 
			CASE
				WHEN LEN(T_Video.Name) > 16 THEN CONCAT(SUBSTRING(T_Video.Name, 0, 15), '...')
				ELSE T_Video.Name
			END [Video.Name], 
			T_Log.ID_Comment [Comment.Id], 
			CASE
				WHEN LEN(T_Comment.Text) > 16 THEN CONCAT(SUBSTRING(T_Comment.Text, 0, 15), '...')
				ELSE T_Comment.Text
			END [Comment.Text], 
			T_Log.ID_Playlist [Playlist.Id], 
			CASE
				WHEN LEN(T_Playlist.Name) > 16 THEN CONCAT(SUBSTRING(T_Playlist.Name, 0, 15), '...')
				ELSE T_Playlist.Name
			END [Playlist.Name], 
			ROW_NUMBER() OVER (ORDER BY T_Log.Time DESC) [num]
		FROM T_Log
		JOIN S_EventType ON T_Log.ID_EventType = S_EventType.ID_EventType
		JOIN T_User ON T_Log.ID_User = T_User.ID_User
		LEFT JOIN T_Video ON T_Log.ID_Video = T_Video.ID_Video
		LEFT JOIN T_Comment ON T_Log.ID_Comment = T_Comment.ID_Comment
		LEFT JOIN T_Playlist ON T_Log.ID_Playlist = T_Playlist.ID_Playlist
	) [tmp] WHERE tmp.num > (@page - 1) * @perpage
END
GO
/****** Object:  StoredProcedure [dbo].[W_AdminGetStats]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AdminGetStats]
AS
BEGIN
	SELECT 
		(SELECT COUNT(*) FROM T_Video) AS [videos], 
		(SELECT COUNT(*) FROM T_User) AS [users],
		(SELECT COUNT(*) FROM T_Playlist) AS [playlists],
		(SELECT COUNT(*) FROM T_Comment) AS [comments],
		(SELECT COUNT(*) FROM T_Log) AS [events],
		(SELECT COUNT(*) FROM T_Token WHERE Expires > GETDATE()) AS [sessions]
END
GO
/****** Object:  StoredProcedure [dbo].[W_AdminGetUsers]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AdminGetUsers]
@page int = 1,
@perpage int = 16
AS
BEGIN
	DECLARE @total int = (SELECT COUNT(*) FROM T_User);
	SELECT TOP (@perpage) *, @total [Total] FROM (
		SELECT T_User.*, S_Role.Caption [Role], COALESCE(VID.cnt, 0) [Videos], COALESCE(PLS.cnt, 0) [Playlists], ROW_NUMBER() OVER (ORDER BY T_User.ID_User) [num]
		FROM T_User
		LEFT JOIN S_Role ON S_Role.ID_Role = T_User.ID_Role
		LEFT JOIN (SELECT ID_User, COUNT(ID_User) [cnt] FROM T_Video GROUP BY ID_User) AS VID ON VID.ID_User = T_User.ID_User
		LEFT JOIN (SELECT ID_User, COUNT(ID_User) [cnt] FROM T_Playlist GROUP BY ID_User) AS PLS ON PLS.ID_User = T_User.ID_User
	) [tmp] WHERE tmp.num > (@page - 1) * @perpage
END
GO
/****** Object:  StoredProcedure [dbo].[W_AdminTerminateSession]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_AdminTerminateSession]
@id int = 0
AS
BEGIN
	UPDATE T_Token 
	SET Expires = GETDATE() 
	WHERE ID_Token = @id AND Expires > GETDATE()
END
GO
/****** Object:  StoredProcedure [dbo].[W_ChangePassword]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[W_ChangePassword]
@id int,
@oldpwdhash varchar(32),
@newpwdhash varchar(32)
AS
BEGIN
	IF EXISTS (SELECT * FROM T_User WHERE ID_User = @id AND PasswordHash = @oldpwdhash)
	BEGIN
		SELECT 0 [ERROR]
		UPDATE T_User SET PasswordHash = @newpwdhash WHERE ID_User = @id AND PasswordHash = @oldpwdhash
	END
	ELSE
		SELECT 1 [ERROR]
END

GO
/****** Object:  StoredProcedure [dbo].[W_CheckToken]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[W_CheckToken]
	-- Add the parameters for the stored procedure here
	@token varchar(32),
	@ip varchar(16)
AS
BEGIN
	DECLARE @ipbin binary(4) =
		CAST( CAST( PARSENAME( @ip, 4 ) AS INTEGER) AS BINARY(1)) +
		CAST( CAST( PARSENAME( @ip, 3 ) AS INTEGER) AS BINARY(1)) +
		CAST( CAST( PARSENAME( @ip, 2 ) AS INTEGER) AS BINARY(1)) +
		CAST( CAST( PARSENAME( @ip, 1 ) AS INTEGER) AS BINARY(1));
	IF EXISTS (SELECT * FROM T_Token WHERE Value like @token AND Expires > GETDATE() AND IP = @ipbin)
	BEGIN
		DECLARE @expires datetime = GETDATE() + 1.0/24
		SELECT 0 [ERROR], @expires [EXPIRATION]
		UPDATE T_Token SET Expires = @expires WHERE Value = @token
	END
	ELSE
		SELECT 1 [ERROR]
END
GO
/****** Object:  StoredProcedure [dbo].[W_EditPlaylist]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_EditPlaylist]
@userid int,
@plsid int,
@name varchar(255)
AS
BEGIN
	IF EXISTS (
		SELECT * 
		FROM T_Playlist 
		LEFT JOIN T_User ON T_User.ID_User = @userid
		WHERE T_Playlist.ID_Playlist = @plsid AND (T_Playlist.ID_User = @userid OR T_User.ID_Role = 1))
	BEGIN
		SELECT 0 [ERROR]
		UPDATE T_Playlist SET Name = @name WHERE ID_Playlist = @plsid
	END	
	ELSE
		SELECT 1 [ERROR]
END
GO
/****** Object:  StoredProcedure [dbo].[W_EditUser]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_EditUser]
	-- Add the parameters for the stored procedure here
	@id int,
	@name varchar(64),
	@info varchar(255),
	@locale varchar(8),
	@theme varchar(8)
AS
BEGIN
	IF EXISTS (SELECT * FROM T_User WHERE ID_User = @id)
	BEGIN
		SELECT 0 [ERROR];
		UPDATE T_User
		SET
			Name = @name,
			Info = @info,
			Locale = @locale,
			Theme = @theme
		WHERE ID_User = @id;
	END
	ELSE
		SELECT 1 [ERROR];
END
GO
/****** Object:  StoredProcedure [dbo].[W_EditVideo]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_EditVideo]
@name varchar(255),
@pub bit,
@id int
AS
BEGIN
	UPDATE T_Video SET Name = @name, Is_Public = @pub WHERE ID_Video = @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetCommentsByVideoAlias]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetCommentsByVideoAlias]
@alias varchar(8)
AS
BEGIN
	SELECT T_Comment.*, COALESCE(T_Log.Time, CONVERT(datetime, '1970-01-01 00:00:00')) [Time]
	FROM T_Comment 
	JOIN T_Video ON T_Comment.ID_Video = T_Video.ID_Video AND T_Video.Alias = @alias COLLATE Latin1_General_CS_AS
	LEFT JOIN T_Log ON T_Comment.ID_Comment = T_Log.ID_Comment AND T_Log.ID_EventType = 7
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetPlaylist]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetPlaylist]
@id int
AS
BEGIN
	SELECT * FROM T_Playlist WHERE ID_Playlist = @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetPlaylistCountByUserID]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetPlaylistCountByUserID]
@id int
AS
BEGIN
	SELECT COUNT(*) [cnt] 
	FROM T_Playlist
	WHERE T_Playlist.ID_User = @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetPlaylistEntries]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetPlaylistEntries]
@plsid int
AS
BEGIN
	SELECT * FROM T_PlaylistEntry WHERE ID_Playlist = @plsid
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetPlaylistsByUser]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetPlaylistsByUser]
@id int
AS
BEGIN
	SELECT * FROM T_Playlist WHERE ID_User = @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetRandomVideos]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetRandomVideos]
@userid int,
@limit int
AS
BEGIN
	SELECT TOP (@limit) T_Video.*
	FROM T_Video
	LEFT JOIN T_User ON T_User.ID_User = @userid
	WHERE T_Video.Is_Public = 1 OR T_User.ID_Role = 1 OR T_Video.ID_User = @userid
	ORDER BY NEWID()
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetUser]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetUser]
	-- Add the parameters for the stored procedure here
	@token varchar(32) = null,
	@id int = null
AS
BEGIN
	IF @id IS NULL
		SELECT 
			T_User.*, S_Role.Caption [Role], COALESCE(VID.cnt, 0) [Videos], COALESCE(PLS.cnt, 0) [Playlists]
		FROM T_User
		JOIN T_Token ON T_User.id_user = T_Token.id_user AND T_Token.Value like @token AND T_Token.Expires > GETDATE()
		LEFT JOIN S_Role ON S_Role.ID_Role = T_User.ID_Role
		LEFT JOIN (SELECT ID_User, COUNT(ID_User) [cnt] FROM T_Video GROUP BY ID_User) AS VID ON VID.ID_User = T_User.ID_User
		LEFT JOIN (SELECT ID_User, COUNT(ID_User) [cnt] FROM T_Playlist GROUP BY ID_User) AS PLS ON PLS.ID_User = T_User.ID_User
	ELSE
		SELECT 
			T_User.*, S_Role.Caption [Role], COALESCE(VID.cnt, 0) [Videos], COALESCE(PLS.cnt, 0) [Playlists]
		FROM T_User
		LEFT JOIN S_Role ON S_Role.ID_Role = T_User.ID_Role
		LEFT JOIN (SELECT ID_User, COUNT(ID_User) [cnt] FROM T_Video GROUP BY ID_User) AS VID ON VID.ID_User = T_User.ID_User
		LEFT JOIN (SELECT ID_User, COUNT(ID_User) [cnt] FROM T_Playlist GROUP BY ID_User) AS PLS ON PLS.ID_User = T_User.ID_User
		WHERE T_User.ID_User = @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetVideoByAlias]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetVideoByAlias]
@userid int,
@alias varchar(8)
AS
BEGIN
	DECLARE @id int = (SELECT ID_Video FROM T_Video WHERE Alias = @alias COLLATE Latin1_General_CS_AS)
	EXECUTE W_GetVideoByID @userid, @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetVideoByID]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetVideoByID]
@userid int,
@id int
AS
BEGIN
	SELECT TOP 1 T_Video.*, COALESCE(T_Log.Time, CONVERT(datetime, '1970-01-01 00:00:00')) [Time]
	FROM T_Video
	LEFT JOIN T_User ON T_User.ID_User = @userid
	LEFT JOIN T_Log ON T_Video.ID_Video = T_Log.ID_Video AND T_Log.ID_EventType = 3
	WHERE (T_Video.ID_User = @userid OR T_Video.Is_Public = 1 OR T_User.ID_Role = 1) AND T_Video.ID_Video = @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetVideoCountByUserID]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetVideoCountByUserID]
@id int
AS
BEGIN
	SELECT COUNT(*) [cnt] 
	FROM T_Video
	WHERE T_Video.ID_User = @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetVideos]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetVideos]
@userid int,
@req int,
@perpage tinyint,
@page smallint
AS
BEGIN
	SELECT TOP (@perpage) * FROM (
		SELECT T_Video.*, ROW_NUMBER() OVER (ORDER BY ID_Video) AS RowNum
		FROM T_Video
		LEFT JOIN T_User on T_User.ID_User = @req
		WHERE T_Video.ID_User = @userid AND (Is_Public = 1 OR @req = @userid OR T_User.ID_Role = 1)
	) AS TMP WHERE TMP.RowNum > (@page - 1) * @perpage
END
GO
/****** Object:  StoredProcedure [dbo].[W_GetVideosCount]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_GetVideosCount]
@userid int,
@req int,
@perpage tinyint = 16,
@page smallint = 1
AS
BEGIN
	SELECT COUNT(*) [CNT]
	FROM T_Video
	LEFT JOIN T_User on T_User.ID_User = @req
	WHERE T_Video.ID_User = @userid AND (Is_Public = 1 OR @req = @userid OR T_User.ID_Role = 1);
END
GO
/****** Object:  StoredProcedure [dbo].[W_Login]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[W_Login]
	-- Add the parameters for the stored procedure here
	@login varchar(64),
	@pwdhash varchar(32),
	@ip varchar(16)
AS
BEGIN
	DECLARE @userid int = (SELECT id_user FROM T_User WHERE T_User.Login = @login and T_User.PasswordHash = @pwdhash)

    IF @userid IS NULL
		SELECT 1 [ERROR]
	ELSE
	BEGIN
		DECLARE @token varchar(32) = REPLACE(NEWID(),'-','')
		DECLARE @expire datetime = GETDATE() + 1.0/24
		DECLARE @ipbin binary(4) =
			CAST( CAST( PARSENAME( @ip, 4 ) AS INTEGER) AS BINARY(1)) +
			CAST( CAST( PARSENAME( @ip, 3 ) AS INTEGER) AS BINARY(1)) +
			CAST( CAST( PARSENAME( @ip, 2 ) AS INTEGER) AS BINARY(1)) +
			CAST( CAST( PARSENAME( @ip, 1 ) AS INTEGER) AS BINARY(1));

		SELECT @token [TOKEN], @expire [EXPIRATION]

		INSERT INTO T_Token (Value, ID_User, IP, Expires) values (@token, @userid, @ipbin, @expire);
	END
END

GO
/****** Object:  StoredProcedure [dbo].[W_Logout]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[W_Logout]
	-- Add the parameters for the stored procedure here
	@token varchar(32)
AS
BEGIN
	UPDATE T_Token
	SET Expires = GETDATE()
	WHERE Value = @token
END

GO
/****** Object:  StoredProcedure [dbo].[W_NewAlias]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_NewAlias]
AS
BEGIN
	DECLARE @alphabet varchar(63) = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
	DECLARE @key varchar(8);
	DECLARE @i int = 0;
	WHILE @i < 8
	BEGIN
		SET @i = @i + 1
		SET @key = CONCAT(@key, SUBSTRING(@alphabet, CONVERT(int, RAND() * 63), 1))
	END

	IF EXISTS(SELECT * FROM T_Video WHERE Alias = @key COLLATE Latin1_General_CS_AS)
		EXECUTE W_NewAlias
	ELSE
		SELECT @key as Alias
END
GO
/****** Object:  StoredProcedure [dbo].[W_Register]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[W_Register]
	-- Add the parameters for the stored procedure here
	@login varchar(32),
	@pwdhash varchar(32),
	@name varchar(64),
	@info varchar(255)
AS
BEGIN
	IF EXISTS (SELECT * FROM T_User WHERE Login like @login)
		SELECT 1 [ERROR]
	ELSE
	BEGIN
		SELECT 0 [ERROR]
		INSERT INTO T_User (ID_Role, Login, PasswordHash, Name, Info)
		VALUES (2, @login, @pwdhash, @name, @info)
	END
END
GO
/****** Object:  StoredProcedure [dbo].[W_RemoveComment]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_RemoveComment]
@userid int,
@id int
AS
BEGIN
	IF EXISTS (
		SELECT TOP 1 T_Comment.* 
		FROM T_Comment
		LEFT JOIN T_User ON T_User.ID_User = @userid
		JOIN T_Video ON T_Comment.ID_Video = T_Video.ID_Video
		WHERE (T_Comment.ID_User = @userid OR T_Video.ID_User = @userid OR T_User.ID_Role = 1) AND T_Comment.ID_Comment = @id
	)
	BEGIN
		SELECT 0 [ERROR]
		DELETE FROM T_Comment WHERE T_Comment.ID_Comment = @id
	END
	ELSE
		SELECT 1 [ERROR]
END
GO
/****** Object:  StoredProcedure [dbo].[W_RemovePlaylist]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_RemovePlaylist]
@userid int,
@plsid int
AS
BEGIN
	IF EXISTS (
		SELECT * 
		FROM T_Playlist 
		LEFT JOIN T_User ON T_User.ID_User = @userid
		WHERE T_Playlist.ID_Playlist = @plsid AND (T_Playlist.ID_User = @userid OR T_User.ID_Role = 1))
	BEGIN
		SELECT 0 [ERROR]
		DELETE FROM T_PlaylistEntry WHERE ID_Playlist = @plsid
		DELETE FROM T_Playlist WHERE ID_Playlist = @plsid
	END	
	ELSE
		SELECT 1 [ERROR]
END
GO
/****** Object:  StoredProcedure [dbo].[W_RemovePlaylistEntry]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_RemovePlaylistEntry]
@userid int,
@plsid int,
@videoid int
AS
BEGIN
	IF EXISTS (
		SELECT * 
		FROM T_Playlist 
		LEFT JOIN T_User ON T_User.ID_User = @userid
		WHERE ID_Playlist = @plsid AND (T_Playlist.ID_User = @userid OR T_User.ID_Role = 1)
		)
	BEGIN
		SELECT 0 [ERROR]
		DELETE FROM T_PlaylistEntry WHERE ID_Playlist = @plsid AND ID_Video = @videoid
	END
	ELSE
		SELECT 1 [ERROR]
END
GO
/****** Object:  StoredProcedure [dbo].[W_RemoveVideoByID]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_RemoveVideoByID]
@id int
AS
BEGIN
	DELETE FROM T_PlaylistEntry WHERE ID_Video = @id
	DELETE FROM T_Comment WHERE ID_Video = @id
	DELETE FROM T_Video WHERE ID_Video = @id
END
GO
/****** Object:  StoredProcedure [dbo].[W_SearchVideo]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_SearchVideo]
@querymask varchar(64),
@perpage tinyint = 16,
@page smallint = 1,
@userid int,
@own bit = 0
AS
BEGIN
	SELECT TOP (@perpage) * FROM (
		SELECT T_Video.*, ROW_NUMBER() OVER (ORDER BY ID_Video) AS RowNum
		FROM T_Video
		LEFT JOIN T_User ON T_User.ID_User = @userid
		WHERE (T_Video.ID_User = @userid OR @own = 0 AND (T_Video.Is_Public = 1 OR T_User.ID_Role = 1)) AND T_Video.Name LIKE @querymask
	) AS TMP WHERE TMP.RowNum > (@page - 1) * @perpage
END
GO
/****** Object:  StoredProcedure [dbo].[W_SearchVideoCount]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[W_SearchVideoCount]
@querymask varchar(64),
@userid int,
@own bit = 0
AS
BEGIN
	SELECT COUNT(*) [CNT]
	FROM T_Video
	LEFT JOIN T_User ON T_User.ID_User = @userid
	WHERE (T_Video.ID_User = @userid OR @own = 0 AND (T_Video.Is_Public = 1 OR T_User.ID_Role = 1)) AND T_Video.Name LIKE @querymask;
END
GO
/****** Object:  StoredProcedure [dbo].[WS_GetRoleCollection]    Script Date: 16.05.2023 9:38:26 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[WS_GetRoleCollection]
AS
BEGIN
	SELECT ID_Role as id, Caption as name FROM S_Role
END

